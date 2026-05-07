<?php
/**
 * Fix production SQLite database column misalignment.
 *
 * The import script (import-mysql-dump-to-sqlite.php) had issues with column
 * ordering because later migrations add columns at the END of SQLite tables,
 * but MySQL migrations use ->after() to position columns in the middle.
 *
 * This script re-imports data from the MySQL dump (database_dump.sql) using
 * the column lists in the INSERT statements for correct column-value alignment.
 *
 * Tables affected:
 * - trekking_routes: editorial columns at end of SQLite vs middle in MySQL (16 rows)
 * - departures: total_seats/held_seats at end of SQLite vs middle in MySQL (30 rows)
 */

$sqlitePath = __DIR__ . '/../database/database.sqlite';
$dumpPath = __DIR__ . '/../database_dump.sql';

if (!file_exists($sqlitePath)) {
    echo "ERROR: SQLite database not found at {$sqlitePath}\n";
    exit(1);
}
if (!file_exists($dumpPath)) {
    echo "ERROR: MySQL dump not found at {$dumpPath}\n";
    exit(1);
}

$db = new PDO("sqlite:{$sqlitePath}");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = OFF');

echo "========================================\n";
echo "  FIXING PRODUCTION SQLITE DATABASE\n";
echo "========================================\n\n";

$dump = file_get_contents($dumpPath);

// ============================================================
// Helper functions
// ============================================================
function parseValuesBlock(string $block): array {
    $rows = [];
    $len = strlen($block);
    $i = 0; $depth = 0; $current = ''; $inString = false; $stringChar = null;
    while ($i < $len) {
        $ch = $block[$i];
        if ($inString) {
            if ($ch === '\\' && $i + 1 < $len) { $current .= $ch . $block[$i + 1]; $i += 2; continue; }
            $current .= $ch;
            if ($ch === $stringChar) { $inString = false; $stringChar = null; }
            $i++; continue;
        }
        if ($ch === "'" || $ch === '"') { $inString = true; $stringChar = $ch; $current .= $ch; $i++; continue; }
        if ($ch === '(' && $depth === 0) { $depth = 1; $current = ''; $i++; continue; }
        if ($ch === '(' && $depth > 0) { $depth++; $current .= $ch; $i++; continue; }
        if ($ch === ')' && $depth > 0) {
            $depth--;
            if ($depth === 0) { $rows[] = parseRowValues($current); $current = ''; $i++; while ($i < $len && ($block[$i] === ',' || $block[$i] === ' ' || $block[$i] === "\n" || $block[$i] === "\r" || $block[$i] === "\t")) $i++; continue; }
            $current .= $ch; $i++; continue;
        }
        if ($depth > 0) $current .= $ch;
        $i++;
    }
    return $rows;
}

function parseRowValues(string $values): array {
    $result = []; $len = strlen($values); $i = 0; $current = ''; $inString = false; $stringChar = null; $depth = 0;
    while ($i < $len) {
        $ch = $values[$i];
        if ($inString) {
            if ($ch === '\\' && $i + 1 < $len) { $current .= $ch . $values[$i + 1]; $i += 2; continue; }
            $current .= $ch;
            if ($ch === $stringChar) { $inString = false; $stringChar = null; }
            $i++; continue;
        }
        if ($ch === "'" || $ch === '"') { $inString = true; $stringChar = $ch; $current .= $ch; $i++; continue; }
        if ($ch === '(') { $depth++; $current .= $ch; $i++; continue; }
        if ($ch === ')') { $depth--; $current .= $ch; $i++; continue; }
        if ($ch === ',' && $depth === 0) { $result[] = trim($current); $current = ''; $i++; continue; }
        $current .= $ch; $i++;
    }
    if (trim($current) !== '') $result[] = trim($current);
    return $result;
}

function convertMysqlValue(string $value): mixed {
    $value = trim($value);
    if (strtoupper($value) === 'NULL') return null;
    if (strtoupper($value) === 'TRUE') return 1;
    if (strtoupper($value) === 'FALSE') return 0;
    if ((str_starts_with($value, "'") && str_ends_with($value, "'")) || (str_starts_with($value, '"') && str_ends_with($value, '"'))) {
        $inner = substr($value, 1, -1);
        $inner = str_replace(["\\'", '\\"', '\\\\', '\\n', '\\r', '\\t', '\\0', '\\Z', '\\b'], ["'", '"', '\\', "\n", "\r", "\t", "\0", "\x1a", "\x08"], $inner);
        $inner = preg_replace('/\\\\(.)/', '$1', $inner);
        return $inner;
    }
    if (is_numeric($value)) return str_contains($value, '.') ? (float)$value : (int)$value;
    return $value;
}

function getSqliteColumns(PDO $db, string $table): array {
    $stmt = $db->query("PRAGMA table_info({$table})");
    $cols = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cols[] = $row['name'];
    }
    return $cols;
}

function extractInsertData(string $dump, string $table): ?array {
    // Match INSERT with optional column list
    $pattern = '/INSERT INTO `' . preg_quote($table) . '`\s*(\([^)]+\))?\s*VALUES\s*(.*?);\s*$/s';
    if (!preg_match($pattern, $dump, $match)) {
        return null;
    }
    
    $columnList = isset($match[1]) ? $match[1] : null;
    $valuesBlock = $match[2];
    
    // Parse column list
    $mysqlColumns = [];
    if ($columnList) {
        $colStr = trim($columnList, '()');
        $mysqlColumns = array_map('trim', explode(',', $colStr));
        $mysqlColumns = array_map(function($c) { return trim($c, '`'); }, $mysqlColumns);
    }
    
    $rows = parseValuesBlock($valuesBlock);
    
    return [
        'columns' => $mysqlColumns,
        'rows' => $rows,
    ];
}

// ============================================================
// 1. FIX TREKKING_ROUTES
// ============================================================
echo "--- Fixing trekking_routes ---\n";

$data = extractInsertData($dump, 'trekking_routes');
if (!$data) {
    echo "ERROR: Could not find trekking_routes INSERT in dump\n";
    exit(1);
}

$mysqlCols = $data['columns'];
$mysqlRows = $data['rows'];
$sqliteCols = getSqliteColumns($db, 'trekking_routes');

echo "MySQL columns (" . count($mysqlCols) . "): " . implode(', ', $mysqlCols) . "\n";
echo "SQLite columns (" . count($sqliteCols) . "): " . implode(', ', $sqliteCols) . "\n";

// Build mapping: for each SQLite column, which MySQL column index provides its value?
$sqliteToMysql = [];
foreach ($sqliteCols as $sqliteCol) {
    $mysqlIdx = array_search($sqliteCol, $mysqlCols);
    if ($mysqlIdx === false) {
        // Column doesn't exist in MySQL dump (e.g., meta_title, meta_description added later)
        $sqliteToMysql[] = -1;
    } else {
        $sqliteToMysql[] = $mysqlIdx;
    }
}

echo "\nColumn mapping:\n";
foreach ($sqliteCols as $i => $col) {
    $src = $sqliteToMysql[$i] >= 0 ? "MySQL[{$sqliteToMysql[$i]}]" : "NULL (not in dump)";
    echo "  SQLite[{$i}] {$col} <- {$src}\n";
}

// Clear existing data
echo "\nClearing existing trekking_routes data...\n";
$db->exec('DELETE FROM trekking_routes');

// Re-insert with correct mapping
$colList = '`' . implode('`,`', $sqliteCols) . '`';
$placeholders = '(' . implode(',', array_fill(0, count($sqliteCols), '?')) . ')';
$insertStmt = $db->prepare("INSERT INTO `trekking_routes` ({$colList}) VALUES {$placeholders}");

$inserted = 0;
$errors = 0;
foreach ($mysqlRows as $mysqlRow) {
    $sqliteRow = [];
    foreach ($sqliteToMysql as $mysqlIdx) {
        if ($mysqlIdx >= 0 && isset($mysqlRow[$mysqlIdx])) {
            $sqliteRow[] = convertMysqlValue($mysqlRow[$mysqlIdx]);
        } else {
            $sqliteRow[] = null;
        }
    }
    try {
        $insertStmt->execute($sqliteRow);
        $inserted++;
    } catch (PDOException $e) {
        echo "  ERROR id={$sqliteRow[0]}: " . $e->getMessage() . "\n";
        $errors++;
    }
}
echo "Re-inserted {$inserted} trekking_routes rows ({$errors} errors)\n\n";

// ============================================================
// 2. FIX DEPARTURES
// ============================================================
echo "--- Fixing departures ---\n";

$data = extractInsertData($dump, 'departures');
if (!$data) {
    echo "ERROR: Could not find departures INSERT in dump\n";
    exit(1);
}

$mysqlCols = $data['columns'];
$mysqlRows = $data['rows'];
$sqliteCols = getSqliteColumns($db, 'departures');

echo "MySQL columns (" . count($mysqlCols) . "): " . implode(', ', $mysqlCols) . "\n";
echo "SQLite columns (" . count($sqliteCols) . "): " . implode(', ', $sqliteCols) . "\n";

// Build mapping
$sqliteToMysql = [];
foreach ($sqliteCols as $sqliteCol) {
    $mysqlIdx = array_search($sqliteCol, $mysqlCols);
    $sqliteToMysql[] = $mysqlIdx === false ? -1 : $mysqlIdx;
}

echo "\nColumn mapping:\n";
foreach ($sqliteCols as $i => $col) {
    $src = $sqliteToMysql[$i] >= 0 ? "MySQL[{$sqliteToMysql[$i]}]" : "NULL (not in dump)";
    echo "  SQLite[{$i}] {$col} <- {$src}\n";
}

// Clear existing data
echo "\nClearing existing departures data...\n";
$db->exec('DELETE FROM departures');

// Re-insert with correct mapping
$colList = '`' . implode('`,`', $sqliteCols) . '`';
$placeholders = '(' . implode(',', array_fill(0, count($sqliteCols), '?')) . ')';
$insertStmt = $db->prepare("INSERT INTO `departures` ({$colList}) VALUES {$placeholders}");

$inserted = 0;
$errors = 0;
foreach ($mysqlRows as $mysqlRow) {
    $sqliteRow = [];
    foreach ($sqliteToMysql as $mysqlIdx) {
        if ($mysqlIdx >= 0 && isset($mysqlRow[$mysqlIdx])) {
            $sqliteRow[] = convertMysqlValue($mysqlRow[$mysqlIdx]);
        } else {
            $sqliteRow[] = null;
        }
    }
    try {
        $insertStmt->execute($sqliteRow);
        $inserted++;
    } catch (PDOException $e) {
        echo "  ERROR id={$sqliteRow[0]}: " . $e->getMessage() . "\n";
        $errors++;
    }
}
echo "Re-inserted {$inserted} departures rows ({$errors} errors)\n\n";

// ============================================================
// 3. FIX BLOG_POSTS
// ============================================================
echo "--- Fixing blog_posts ---\n";

$data = extractInsertData($dump, 'blog_posts');
if (!$data) {
    echo "ERROR: Could not find blog_posts INSERT in dump\n";
    exit(1);
}

$mysqlCols = $data['columns'];
$mysqlRows = $data['rows'];
$sqliteCols = getSqliteColumns($db, 'blog_posts');

echo "MySQL columns (" . count($mysqlCols) . "): " . implode(', ', $mysqlCols) . "\n";
echo "SQLite columns (" . count($sqliteCols) . "): " . implode(', ', $sqliteCols) . "\n";

// Build mapping
$sqliteToMysql = [];
foreach ($sqliteCols as $sqliteCol) {
    $mysqlIdx = array_search($sqliteCol, $mysqlCols);
    $sqliteToMysql[] = $mysqlIdx === false ? -1 : $mysqlIdx;
}

echo "\nColumn mapping:\n";
foreach ($sqliteCols as $i => $col) {
    $src = $sqliteToMysql[$i] >= 0 ? "MySQL[{$sqliteToMysql[$i]}]" : "NULL (not in dump)";
    echo "  SQLite[{$i}] {$col} <- {$src}\n";
}

// Clear existing data
echo "\nClearing existing blog_posts data...\n";
$db->exec('DELETE FROM blog_posts');

// Re-insert with correct mapping
$colList = '`' . implode('`,`', $sqliteCols) . '`';
$placeholders = '(' . implode(',', array_fill(0, count($sqliteCols), '?')) . ')';
$insertStmt = $db->prepare("INSERT INTO `blog_posts` ({$colList}) VALUES {$placeholders}");

$inserted = 0;
$errors = 0;
foreach ($mysqlRows as $mysqlRow) {
    $sqliteRow = [];
    foreach ($sqliteToMysql as $mysqlIdx) {
        if ($mysqlIdx >= 0 && isset($mysqlRow[$mysqlIdx])) {
            $sqliteRow[] = convertMysqlValue($mysqlRow[$mysqlIdx]);
        } else {
            $sqliteRow[] = null;
        }
    }
    try {
        $insertStmt->execute($sqliteRow);
        $inserted++;
    } catch (PDOException $e) {
        echo "  ERROR id={$sqliteRow[0]}: " . $e->getMessage() . "\n";
        $errors++;
    }
}
echo "Re-inserted {$inserted} blog_posts rows ({$errors} errors)\n\n";

// ============================================================
// 4. VERIFICATION
// ============================================================
echo "========================================\n";
echo "  VERIFICATION\n";
echo "========================================\n\n";

echo "Trekking routes sample:\n";
$stmt = $db->query('SELECT id, name, slug, success_rate, updated_at, editorial_image, editorial_image_2, editorial_content FROM trekking_routes LIMIT 5');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "  " . json_encode($row) . "\n";
}

echo "\nDepartures sample:\n";
$stmt = $db->query('SELECT id, trekking_route_id, departure_date, return_date, price_cents, total_seats, available_seats, booked_seats, held_seats, status, created_at, updated_at FROM departures LIMIT 5');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "  " . json_encode($row) . "\n";
}

echo "\nBlog posts sample:\n";
$stmt = $db->query('SELECT id, slug, title, excerpt, hero_image, author, category, published_at, created_at, updated_at, meta_title, meta_description FROM blog_posts LIMIT 3');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "  " . json_encode($row) . "\n";
}

echo "\nDone. Database fixed successfully.\n";
