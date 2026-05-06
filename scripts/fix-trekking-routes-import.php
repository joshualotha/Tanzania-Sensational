<?php
/**
 * Fix trekking_routes table data that was imported with wrong column order.
 *
 * MySQL CREATE TABLE column order (21 columns):
 *   0:id, 1:name, 2:slug, 3:meta_badge, 4:description, 5:difficulty,
 *   6:duration, 7:distance, 8:elevation_gain, 9:base_price, 10:max_group_size,
 *   11:hero_image, 12:editorial_image, 13:editorial_image_2, 14:editorial_content,
 *   15:success_rate, 16:highlights, 17:created_at, 18:updated_at,
 *   19:inclusions, 20:exclusions
 *
 * SQLite column order (21 columns):
 *   0:id, 1:name, 2:slug, 3:meta_badge, 4:description, 5:difficulty,
 *   6:duration, 7:distance, 8:elevation_gain, 9:base_price, 10:max_group_size,
 *   11:hero_image, 12:success_rate, 13:highlights, 14:created_at, 15:updated_at,
 *   16:inclusions, 17:exclusions, 18:editorial_image, 19:editorial_image_2, 20:editorial_content
 *
 * The editorial columns were added by a later migration (2026_04_12_133122), so in SQLite
 * they appear at the END (positions 18-20), but in MySQL they were inserted in the MIDDLE
 * (positions 12-14, between hero_image and success_rate).
 *
 * Mapping: SQLite pos => MySQL pos
 *   0->0, 1->1, 2->2, 3->3, 4->4, 5->5, 6->6, 7->7, 8->8, 9->9, 10->10, 11->11
 *   12->15 (success_rate), 13->16 (highlights), 14->17 (created_at), 15->18 (updated_at)
 *   16->19 (inclusions), 17->20 (exclusions)
 *   18->12 (editorial_image), 19->13 (editorial_image_2), 20->14 (editorial_content)
 */

$sqlitePath = __DIR__ . '/../database/database.sqlite';
$dumpPath = __DIR__ . '/../final.sql';

$db = new PDO("sqlite:{$sqlitePath}");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = OFF');

$dump = file_get_contents($dumpPath);

// Extract trekking_routes INSERT
preg_match('/INSERT INTO `trekking_routes` VALUES\s*(.*?);\s*$/sm', $dump, $match);
$valuesBlock = $match[1];

// Parse function
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

echo "Parsing trekking_routes data...\n";
$rows = parseValuesBlock($valuesBlock);
echo "Found " . count($rows) . " rows\n";

// SQLite pos => MySQL pos mapping
// MySQL has editorial columns at positions 12-14 (between hero_image and success_rate)
// SQLite has editorial columns at positions 18-20 (at the end, added by later migration)
$sqliteToMysql = [0,1,2,3,4,5,6,7,8,9,10,11, 15,16,17,18,19,20, 12,13,14];

$sqliteColumns = ['id','name','slug','meta_badge','description','difficulty','duration','distance','elevation_gain','base_price','max_group_size','hero_image','success_rate','highlights','created_at','updated_at','inclusions','exclusions','editorial_image','editorial_image_2','editorial_content'];
$sqliteTypes = ['INTEGER','varchar','varchar','varchar','TEXT','varchar','INTEGER','varchar','varchar','numeric','INTEGER','varchar','varchar','TEXT','datetime','datetime','TEXT','TEXT','varchar','varchar','TEXT'];

echo "Clearing existing data...\n";
$db->exec('DELETE FROM trekking_routes');

$colList = '`' . implode('`,`', $sqliteColumns) . '`';
$placeholders = '(' . implode(',', array_fill(0, count($sqliteColumns), '?')) . ')';
$insertStmt = $db->prepare("INSERT INTO `trekking_routes` ({$colList}) VALUES {$placeholders}");

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
$stmt = $db->query('SELECT id, name, success_rate, highlights, inclusions, exclusions, editorial_image, editorial_image_2, editorial_content FROM trekking_routes LIMIT 3');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "  " . json_encode($row) . "\n";
}
