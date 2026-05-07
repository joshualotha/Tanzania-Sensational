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
 * - INSERT statements with or without column lists
 * - Column mismatch between MySQL dump and SQLite schema
 *   (when dump has no column list, uses canonical column order)
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
// Supports two formats:
//   Format 1 (phpMyAdmin): INSERT INTO `table` (`col1`, `col2`) VALUES (val1, val2), (val3, val4);
//   Format 2 (mysqldump):  INSERT INTO `table` VALUES (val1, val2), (val3, val4);
// Both formats may span multiple lines.
// Capture group 1: table name
// Capture group 2: column list (if present, including backticks and parentheses)
// Capture group 3: VALUES block (parenthesized tuples)
//
// NOTE: The VALUES block regex uses [^;] inside tuples to avoid matching
// semicolons that may appear inside string values (e.g., HTML entities like &).
// Each tuple is matched as: (...) followed by optional comma and whitespace.
// The entire block ends with ); followed by newline or end-of-file.
preg_match_all('/INSERT INTO `(\w+)`\s*(\(`[^)]+`\))?\s*VALUES\s*((?:\([^;]*?\)\s*,?\s*)+);\s*(?:\n|$)/s', $dump, $matches, PREG_SET_ORDER);

if (empty($matches)) {
    echo "ERROR: No INSERT statements found in dump file.\n";
    echo "The regex may not match the dump format. First 500 chars of dump:\n";
    echo substr($dump, 0, 500) . "\n";
    exit(1);
}

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
    $columnListRaw = $match[2] ?? ''; // e.g., "(`col1`, `col2`)" or empty
    $valuesBlock = $match[3];
    
    echo "Processing table: {$table}\n";
    
    // Parse the VALUES block into individual row tuples
    $rows = parseValuesBlock($valuesBlock);
    
    if (empty($rows)) {
        echo "  WARNING: No rows parsed for table {$table}\n";
        continue;
    }
    
    // Get column info from the SQLite table
    $stmt = $db->query("PRAGMA table_info(`{$table}`)");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $allSqliteColumnNames = array_column($columns, 'name');
    
    if (empty($allSqliteColumnNames)) {
        echo "  WARNING: Table {$table} not found in SQLite, skipping\n";
        $totalSkipped += count($rows);
        continue;
    }
    
    // Determine which columns to use for INSERT
    if (!empty(trim($columnListRaw))) {
        // INSERT has a column list — parse it and map to SQLite columns
        $dumpColumns = parseColumnList($columnListRaw);
        $insertColumns = [];
        foreach ($dumpColumns as $col) {
            if (in_array($col, $allSqliteColumnNames)) {
                $insertColumns[] = $col;
            } else {
                echo "  WARNING: Column '{$col}' not found in SQLite table {$table}, skipping\n";
            }
        }
        if (empty($insertColumns)) {
            echo "  WARNING: No matching columns for table {$table}, skipping\n";
            $totalSkipped += count($rows);
            continue;
        }
    } else {
        // No column list in INSERT — use canonical column order
        // The MySQL dump may have fewer columns than the SQLite table
        // (due to later migrations adding columns).
        // We determine the canonical order from the original migration schema.
        $insertColumns = getCanonicalColumns($table, $allSqliteColumnNames, count($rows[0]));
    }
    
    $placeholders = '(' . implode(',', array_fill(0, count($insertColumns), '?')) . ')';
    $colList = '`' . implode('`,`', $insertColumns) . '`';
    
    $insertStmt = $db->prepare("INSERT INTO `{$table}` ({$colList}) VALUES {$placeholders}");
    
    $inserted = 0;
    foreach ($rows as $rowValues) {
        // Map MySQL values to SQLite, using only the columns we're inserting into
        $typedValues = [];
        foreach ($rowValues as $i => $value) {
            if ($i >= count($insertColumns)) {
                // More values than columns — skip extras
                break;
            }
            // Find the column type from SQLite schema
            $colName = $insertColumns[$i];
            $colType = 'TEXT';
            foreach ($columns as $col) {
                if ($col['name'] === $colName) {
                    $colType = $col['type'] ?? 'TEXT';
                    break;
                }
            }
            $typedValues[] = convertMysqlValue($value, $colType);
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

// ============================================================
// HELPER FUNCTIONS
// ============================================================

/**
 * Parse a column list from an INSERT statement.
 * Input: "(`col1`, `col2`, `col3`)"
 * Output: ["col1", "col2", "col3"]
 */
function parseColumnList(string $raw): array
{
    $raw = trim($raw);
    // Remove outer parentheses
    if (str_starts_with($raw, '(') && str_ends_with($raw, ')')) {
        $raw = substr($raw, 1, -1);
    }
    // Split by comma, trim backticks and whitespace
    $parts = explode(',', $raw);
    $columns = [];
    foreach ($parts as $part) {
        $part = trim($part);
        $part = trim($part, '`');
        $part = trim($part);
        if (!empty($part)) {
            $columns[] = $part;
        }
    }
    return $columns;
}

/**
 * Get the canonical column order for a table when the MySQL dump
 * has no column list. This maps the positional values from the dump
 * to the correct SQLite columns, accounting for columns added by
 * later migrations that don't exist in the dump.
 *
 * The MySQL dump was exported from the original database schema.
 * The SQLite table may have additional columns from later migrations.
 * We need to match the dump's values to the correct SQLite columns.
 *
 * @param string $table The table name
 * @param array $sqliteColumns All column names in the SQLite table
 * @param int $valueCount Number of values in each row of the dump
 * @return array The subset of SQLite columns to insert into, in correct order
 */
function getCanonicalColumns(string $table, array $sqliteColumns, int $valueCount): array
{
    // Define the canonical column order for each table based on the
    // original migration schema at the time the MySQL dump was exported.
    // These are the columns that existed in the original MySQL database.
    static $canonicalMaps = [];
    
    if (empty($canonicalMaps)) {
        $canonicalMaps = [
            'trekking_routes' => [
                'id', 'name', 'slug', 'meta_badge', 'description',
                'difficulty', 'duration', 'distance', 'elevation_gain',
                'base_price', 'max_group_size', 'hero_image',
                'editorial_image', 'editorial_image_2',
                'highlights', 'success_rate',
                'created_at', 'updated_at',
                'inclusions', 'exclusions',
            ],
            'departures' => [
                'id', 'trekking_route_id', 'departure_date', 'return_date',
                'price', 'spots', 'available_spots', 'created_at', 'updated_at',
            ],
            'route_itinerary_days' => [
                'id', 'trekking_route_id', 'day_number', 'title',
                'description', 'elevation_m', 'distance_km', 'hiking_time',
                'habitat', 'accommodation', 'meals',
                'camp_name', 'created_at', 'updated_at',
            ],
            'bookings' => [
                'id', 'departure_id', 'trekking_route_id',
                'first_name', 'last_name', 'email', 'phone', 'nationality',
                'participants', 'total_price', 'message', 'status',
                'booking_type', 'safari_package_id', 'destination_id',
                'safari_start_date', 'safari_end_date',
                'created_at', 'updated_at',
            ],
            'blog_posts' => [
                'id', 'slug', 'title', 'meta_title', 'excerpt',
                'meta_description', 'content', 'content_html',
                'hero_image', 'author', 'category',
                'published_at', 'created_at', 'updated_at',
            ],
            'pages' => [
                'id', 'slug', 'title', 'content_html', 'created_at', 'updated_at',
            ],
            'destinations' => [
                'id', 'name', 'slug', 'description', 'image',
                'highlights', 'created_at', 'updated_at',
            ],
            'safari_packages' => [
                'id', 'destination_id', 'name', 'slug', 'description',
                'duration', 'price', 'image', 'highlights',
                'created_at', 'updated_at',
            ],
            'pricing_rules' => [
                'id', 'trekking_route_id', 'name', 'slug',
                'duration_days', 'price_per_person',
                'private_price_per_person', 'max_participants',
                'is_active', 'created_at', 'updated_at',
            ],
            'gear_items' => [
                'id', 'name', 'category', 'description',
                'rental_price', 'image', 'is_available',
                'created_at', 'updated_at',
            ],
            'gear_rental_requests' => [
                'id', 'booking_id', 'gear_item_id', 'quantity',
                'created_at', 'updated_at',
            ],
            'users' => [
                'id', 'name', 'email', 'email_verified_at',
                'password', 'remember_token',
                'created_at', 'updated_at',
            ],
            'personal_access_tokens' => [
                'id', 'tokenable_type', 'tokenable_id', 'name',
                'token', 'abilities', 'last_used_at',
                'expires_at', 'created_at', 'updated_at',
            ],
            'contact_submissions' => [
                'id', 'name', 'email', 'phone', 'message',
                'is_read', 'created_at', 'updated_at',
            ],
            'visual_assets' => [
                'id', 'section', 'type', 'url', 'alt_text',
                'created_at', 'updated_at',
            ],
            'site_settings' => [
                'id', 'key', 'value', 'created_at', 'updated_at',
            ],
            'admin_notifications' => [
                'id', 'type', 'data', 'is_read',
                'created_at', 'updated_at',
            ],
        ];
    }
    
    if (isset($canonicalMaps[$table])) {
        $canonical = $canonicalMaps[$table];
        // Only use columns that exist in the SQLite table AND are within the value count
        $result = [];
        foreach ($canonical as $col) {
            if (in_array($col, $sqliteColumns) && count($result) < $valueCount) {
                $result[] = $col;
            }
        }
        if (count($result) === $valueCount) {
            return $result;
        }
        // Fallback: if canonical mapping doesn't match value count,
        // try to use the first N SQLite columns
        echo "  WARNING: Canonical column count (" . count($result) . ") doesn't match value count ({$valueCount}) for {$table}, using first {$valueCount} SQLite columns\n";
    } else {
        echo "  WARNING: No canonical column mapping for table {$table}, using first {$valueCount} SQLite columns\n";
    }
    
    // Fallback: use first N SQLite columns
    return array_slice($sqliteColumns, 0, $valueCount);
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
