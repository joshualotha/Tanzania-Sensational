<?php
/**
 * Import MySQL dump data into SQLite database.
 *
 * Usage: php scripts/import-mysql-dump-to-sqlite.php [dump-file]
 *
 * If no dump file is specified, defaults to final.sql in the project root.
 * The dump file path can be absolute or relative to the project root.
 *
 * Examples:
 *   php scripts/import-mysql-dump-to-sqlite.php
 *   php scripts/import-mysql-dump-to-sqlite.php tanzan14_tanzania_sensetional.sql
 *   php scripts/import-mysql-dump-to-sqlite.php /home/user/dump.sql
 *
 * This script reads a MySQL dump, extracts the INSERT statements,
 * and executes them against the SQLite database at database/database.sqlite.
 *
 * It handles:
 * - MySQL hex literals (0x...)
 * - MySQL-style escaped strings
 * - JSON columns (stored as TEXT in SQLite)
 * - NULL values
 * - Boolean expressions (TRUE/FALSE → 1/0)
 */

$sqlitePath = __DIR__ . '/../database/database.sqlite';

// Determine dump file path
$projectRoot = realpath(__DIR__ . '/..');
$dumpArg = $argv[1] ?? 'final.sql';
if (str_starts_with($dumpArg, '/')) {
    // Absolute path
    $dumpPath = $dumpArg;
} else {
    // Relative to project root
    $dumpPath = $projectRoot . '/' . $dumpArg;
}

if (!file_exists($dumpPath)) {
    echo "ERROR: Dump file not found at {$dumpPath}\n";
    exit(1);
}

if (!file_exists($sqlitePath)) {
    echo "ERROR: SQLite database not found at {$sqlitePath}\n";
    echo "Run 'touch database/database.sqlite' and 'php artisan migrate --force' first.\n";
    exit(1);
}

echo "Opening SQLite database: {$sqlitePath}\n";
$db = new PDO("sqlite:{$sqlitePath}");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = OFF');
$db->exec('PRAGMA journal_mode = MEMORY');
$db->exec('PRAGMA synchronous = OFF');

echo "Reading dump file: {$dumpPath}\n";
$dump = file_get_contents($dumpPath);

// Extract all INSERT statements
// MySQL dump format: INSERT INTO `table_name` VALUES (...),(...),...;
preg_match_all('/INSERT INTO `(\w+)` VALUES\s*(.*?);\s*$/sm', $dump, $matches, PREG_SET_ORDER);

// Collect unique table names from the dump, in order of appearance
$tablesInDump = [];
foreach ($matches as $match) {
    $table = $match[1];
    if (!in_array($table, $tablesInDump)) {
        $tablesInDump[] = $table;
    }
}

// Truncate all tables that will be imported (in reverse order to respect FK constraints)
echo "\nTruncating existing data...\n";
$truncated = 0;
foreach (array_reverse($tablesInDump) as $table) {
    try {
        // Check if table exists in SQLite
        $stmt = $db->query("SELECT COUNT(*) FROM sqlite_master WHERE type='table' AND name=" . $db->quote($table));
        if ($stmt->fetchColumn() > 0) {
            $db->exec("DELETE FROM `{$table}`");
            $truncated++;
            echo "  Cleared table: {$table}\n";
        }
    } catch (PDOException $e) {
        echo "  WARNING: Could not clear table {$table}: " . $e->getMessage() . "\n";
    }
}
echo "Cleared {$truncated} tables\n\n";

$totalInserted = 0;
$totalSkipped = 0;

foreach ($matches as $match) {
    $table = $match[1];
    $valuesBlock = $match[2];
    
    echo "Processing table: {$table}\n";
    
    // Parse the VALUES block into individual row tuples
    // Each row is enclosed in (...), and rows are comma-separated
    $rows = parseValuesBlock($valuesBlock);
    
    if (empty($rows)) {
        echo "  WARNING: No rows parsed for table {$table}\n";
        continue;
    }
    
    // Get column info from the SQLite table
    $stmt = $db->query("PRAGMA table_info(`{$table}`)");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $columnNames = array_column($columns, 'name');
    
    if (empty($columnNames)) {
        echo "  WARNING: Table {$table} not found in SQLite, skipping\n";
        $totalSkipped += count($rows);
        continue;
    }
    
    $placeholders = '(' . implode(',', array_fill(0, count($columnNames), '?')) . ')';
    $colList = '`' . implode('`,`', $columnNames) . '`';
    
    $insertStmt = $db->prepare("INSERT INTO `{$table}` ({$colList}) VALUES {$placeholders}");
    
    $inserted = 0;
    foreach ($rows as $rowValues) {
        // Map MySQL values to SQLite
        $typedValues = [];
        foreach ($rowValues as $i => $value) {
            $typedValues[] = convertMysqlValue($value, $columns[$i]['type'] ?? 'TEXT');
        }
        
        try {
            $insertStmt->execute($typedValues);
            $inserted++;
        } catch (PDOException $e) {
            echo "  ERROR inserting into {$table}: " . $e->getMessage() . "\n";
            echo "  Values: " . json_encode($typedValues) . "\n";
            $totalSkipped++;
        }
    }
    
    echo "  Inserted {$inserted} rows into {$table}\n";
    $totalInserted += $inserted;
}

$db->exec('PRAGMA foreign_keys = ON');

echo "\n========================================\n";
echo "IMPORT COMPLETE\n";
echo "Total rows inserted: {$totalInserted}\n";
echo "Total rows skipped:  {$totalSkipped}\n";
echo "========================================\n";

// Verify counts
echo "\nVerification:\n";
$tables = ['migrations', 'users', 'sessions', 'cache', 'jobs', 
           'trekking_routes', 'route_itinerary_days', 'departures',
           'bookings', 'gear_items', 'gear_rental_requests',
           'blog_posts', 'pages', 'destinations', 'safari_packages',
           'pricing_rules', 'personal_access_tokens', 'contact_submissions',
           'visual_assets', 'site_settings', 'admin_notifications'];

foreach ($tables as $table) {
    try {
        $count = $db->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
        if ($count > 0) {
            echo "  {$table}: {$count} rows\n";
        }
    } catch (PDOException $e) {
        // Table might not exist, skip
    }
}

/**
 * Parse the VALUES block from a MySQL INSERT statement.
 * Handles nested parentheses in values like JSON.
 */
function parseValuesBlock(string $block): array
{
    $rows = [];
    $len = strlen($block);
    $i = 0;
    $depth = 0;
    $current = '';
    $inString = false;
    $stringChar = null;
    
    while ($i < $len) {
        $ch = $block[$i];
        
        if ($inString) {
            if ($ch === '\\' && $i + 1 < $len) {
                // Escaped character
                $current .= $ch . $block[$i + 1];
                $i += 2;
                continue;
            }
            $current .= $ch;
            if ($ch === $stringChar) {
                $inString = false;
                $stringChar = null;
            }
            $i++;
            continue;
        }
        
        if ($ch === "'" || $ch === '"') {
            $inString = true;
            $stringChar = $ch;
            $current .= $ch;
            $i++;
            continue;
        }
        
        if ($ch === '(' && $depth === 0) {
            $depth = 1;
            $current = '';
            $i++;
            continue;
        }
        
        if ($ch === '(' && $depth > 0) {
            $depth++;
            $current .= $ch;
            $i++;
            continue;
        }
        
        if ($ch === ')' && $depth > 0) {
            $depth--;
            if ($depth === 0) {
                $rows[] = parseRowValues($current);
                $current = '';
                $i++;
                // Skip comma and whitespace
                while ($i < $len && ($block[$i] === ',' || $block[$i] === ' ' || $block[$i] === "\n" || $block[$i] === "\r" || $block[$i] === "\t")) {
                    $i++;
                }
                continue;
            }
            $current .= $ch;
            $i++;
            continue;
        }
        
        if ($depth > 0) {
            $current .= $ch;
        }
        $i++;
    }
    
    return $rows;
}

/**
 * Parse a single row's values (comma-separated within parentheses).
 */
function parseRowValues(string $values): array
{
    $result = [];
    $len = strlen($values);
    $i = 0;
    $current = '';
    $inString = false;
    $stringChar = null;
    $depth = 0;
    
    while ($i < $len) {
        $ch = $values[$i];
        
        if ($inString) {
            if ($ch === '\\' && $i + 1 < $len) {
                $current .= $ch . $values[$i + 1];
                $i += 2;
                continue;
            }
            $current .= $ch;
            if ($ch === $stringChar) {
                $inString = false;
                $stringChar = null;
            }
            $i++;
            continue;
        }
        
        if ($ch === "'" || $ch === '"') {
            $inString = true;
            $stringChar = $ch;
            $current .= $ch;
            $i++;
            continue;
        }
        
        if ($ch === '(') {
            $depth++;
            $current .= $ch;
            $i++;
            continue;
        }
        
        if ($ch === ')') {
            $depth--;
            $current .= $ch;
            $i++;
            continue;
        }
        
        if ($ch === ',' && $depth === 0) {
            $result[] = trim($current);
            $current = '';
            $i++;
            continue;
        }
        
        $current .= $ch;
        $i++;
    }
    
    if (trim($current) !== '') {
        $result[] = trim($current);
    }
    
    return $result;
}

/**
 * Convert a MySQL value string to the appropriate PHP/SQLite value.
 */
function convertMysqlValue(string $value, string $columnType): mixed
{
    $value = trim($value);
    
    // NULL
    if (strtoupper($value) === 'NULL') {
        return null;
    }
    
    // Boolean
    if (strtoupper($value) === 'TRUE') {
        return 1;
    }
    if (strtoupper($value) === 'FALSE') {
        return 0;
    }
    
    // Hex literal (e.g., 0x...)
    if (preg_match('/^0x[0-9a-fA-F]+$/', $value)) {
        return hex2bin(substr($value, 2));
    }
    
    // String (single or double quoted)
    if ((str_starts_with($value, "'") && str_ends_with($value, "'")) ||
        (str_starts_with($value, '"') && str_ends_with($value, '"'))) {
        $inner = substr($value, 1, -1);
        // Unescape MySQL string escapes
        $inner = str_replace(
            ["\\'", '\\"', '\\\\', '\\n', '\\r', '\\t', '\\0', '\\Z', '\\b'],
            ["'", '"', '\\', "\n", "\r", "\t", "\0", "\x1a", "\x08"],
            $inner
        );
        // Also handle \\' (double backslash before quote)
        $inner = preg_replace('/\\\\(.)/', '$1', $inner);
        return $inner;
    }
    
    // Number
    if (is_numeric($value)) {
        if (str_contains($value, '.')) {
            return (float) $value;
        }
        return (int) $value;
    }
    
    // Fallback: return as-is
    return $value;
}
