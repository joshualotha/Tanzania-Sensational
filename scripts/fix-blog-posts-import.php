<?php
/**
 * Fix blog_posts table data that was imported with wrong column order.
 * 
 * MySQL CREATE TABLE column order (14 columns):
 *   0:id, 1:slug, 2:title, 3:meta_title, 4:excerpt, 5:meta_description, 
 *   6:content, 7:content_html, 8:hero_image, 9:author, 10:category, 
 *   11:published_at, 12:created_at, 13:updated_at
 * 
 * SQLite column order (14 columns):
 *   0:id, 1:slug, 2:title, 3:excerpt, 4:content, 5:hero_image, 
 *   6:author, 7:published_at, 8:created_at, 9:updated_at, 
 *   10:category, 11:content_html, 12:meta_title, 13:meta_description
 * 
 * The MySQL migration used ->after() to position columns, but SQLite ignores ->after()
 * and adds columns at the end. This caused a column order mismatch.
 * 
 * Mapping: SQLite pos => MySQL pos
 *   0->0 (id), 1->1 (slug), 2->2 (title)
 *   3->4 (excerpt), 4->6 (content), 5->8 (hero_image)
 *   6->9 (author), 7->11 (published_at), 8->12 (created_at), 9->13 (updated_at)
 *   10->10 (category), 11->7 (content_html), 12->3 (meta_title), 13->5 (meta_description)
 */

$sqlitePath = __DIR__ . '/../database/database.sqlite';
$dumpPath = __DIR__ . '/../final.sql';

$db = new PDO("sqlite:{$sqlitePath}");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = OFF');

$dump = file_get_contents($dumpPath);

// Extract blog_posts INSERT
preg_match('/INSERT INTO `blog_posts` VALUES\s*(.*?);\s*$/sm', $dump, $match);
$valuesBlock = $match[1];

// Parse functions (same as import-mysql-dump-to-sqlite.php)
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

function convertMysqlValue(string $value, string $columnType): mixed {
    $value = trim($value);
    if (strtoupper($value) === 'NULL') return null;
    if (strtoupper($value) === 'TRUE') return 1;
    if (strtoupper($value) === 'FALSE') return 0;
    if (preg_match('/^0x[0-9a-fA-F]+$/', $value)) return hex2bin(substr($value, 2));
    if ((str_starts_with($value, "'") && str_ends_with($value, "'")) || (str_starts_with($value, '"') && str_ends_with($value, '"'))) {
        $inner = substr($value, 1, -1);
        $inner = str_replace(["\\'", '\\"', '\\\\', '\\n', '\\r', '\\t', '\\0', '\\Z', '\\b'], ["'", '"', '\\', "\n", "\r", "\t", "\0", "\x1a", "\x08"], $inner);
        $inner = preg_replace('/\\\\(.)/', '$1', $inner);
        return $inner;
    }
    if (is_numeric($value)) return str_contains($value, '.') ? (float)$value : (int)$value;
    return $value;
}

echo "Parsing blog_posts data...\n";
$rows = parseValuesBlock($valuesBlock);
echo "Found " . count($rows) . " rows\n";

// SQLite pos => MySQL pos mapping
$sqliteToMysql = [0, 1, 2, 4, 6, 8, 9, 11, 12, 13, 10, 7, 3, 5];

$sqliteColumns = ['id','slug','title','excerpt','content','hero_image','author','published_at','created_at','updated_at','category','content_html','meta_title','meta_description'];
$sqliteTypes = ['INTEGER','varchar','varchar','TEXT','longtext','varchar','varchar','timestamp','timestamp','timestamp','varchar','longtext','varchar','varchar'];

echo "Clearing existing data...\n";
$db->exec('DELETE FROM blog_posts');

$colList = '`' . implode('`,`', $sqliteColumns) . '`';
$placeholders = '(' . implode(',', array_fill(0, count($sqliteColumns), '?')) . ')';
$insertStmt = $db->prepare("INSERT INTO `blog_posts` ({$colList}) VALUES {$placeholders}");

$inserted = 0;
foreach ($rows as $mysqlRow) {
    $sqliteRow = [];
    for ($sqlitePos = 0; $sqlitePos < count($sqliteColumns); $sqlitePos++) {
        $mysqlPos = $sqliteToMysql[$sqlitePos] ?? -1;
        if ($mysqlPos >= 0 && isset($mysqlRow[$mysqlPos])) {
            $sqliteRow[] = convertMysqlValue($mysqlRow[$mysqlPos], $sqliteTypes[$sqlitePos]);
        } else {
            $sqliteRow[] = null;
        }
    }
    try {
        $insertStmt->execute($sqliteRow);
        $inserted++;
    } catch (PDOException $e) {
        echo "  ERROR: " . $e->getMessage() . "\n";
    }
}

echo "Re-inserted {$inserted} rows\n";

// Verify
echo "\nVerification:\n";
$stmt = $db->query('SELECT id, slug, title, meta_title, excerpt, meta_description, content, content_html, hero_image, author, category, published_at, created_at, updated_at FROM blog_posts LIMIT 3');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "  " . json_encode($row, JSON_UNESCAPED_SLASHES) . "\n";
}
