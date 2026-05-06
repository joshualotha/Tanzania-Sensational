<?php
$dump = file_get_contents(__DIR__ . '/../final.sql');

// Extract trekking_routes INSERT
preg_match('/INSERT INTO `trekking_routes` VALUES\s*\(/', $dump, $m, PREG_OFFSET_CAPTURE);
$pos = $m[0][1] + strlen($m[0][0]) - 1; // position after the first (

// Find the closing ) for the first row
$depth = 1;
$end = $pos;
for ($i = $pos + 1; $i < strlen($dump) && $depth > 0; $i++) {
    if ($dump[$i] === '(') $depth++;
    if ($dump[$i] === ')') $depth--;
    $end = $i;
}

$firstRow = substr($dump, $pos + 1, $end - $pos - 1);
echo "First row raw: " . substr($firstRow, 0, 200) . "...\n\n";

// Simple comma split (won't handle nested commas in strings perfectly but good enough for counting)
$depth = 0;
$inString = false;
$char = null;
$values = [];
$current = '';
for ($i = 0; $i < strlen($firstRow); $i++) {
    $ch = $firstRow[$i];
    if ($inString) {
        if ($ch === '\\' && $i + 1 < strlen($firstRow)) {
            $current .= $ch . $firstRow[$i + 1];
            $i++;
            continue;
        }
        $current .= $ch;
        if ($ch === $char) $inString = false;
        continue;
    }
    if ($ch === "'" || $ch === '"') {
        $inString = true;
        $char = $ch;
        $current .= $ch;
        continue;
    }
    if ($ch === '(') { $depth++; $current .= $ch; continue; }
    if ($ch === ')') { $depth--; $current .= $ch; continue; }
    if ($ch === ',' && $depth === 0) {
        $values[] = trim($current);
        $current = '';
        continue;
    }
    $current .= $ch;
}
if (trim($current) !== '') $values[] = trim($current);

echo "Total values in MySQL dump: " . count($values) . "\n\n";
foreach ($values as $i => $v) {
    echo "  $i: " . substr($v, 0, 80) . "\n";
}

// Now check SQLite schema
$db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
$stmt = $db->query('PRAGMA table_info(trekking_routes)');
$cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "\nSQLite columns: " . count($cols) . "\n";
foreach ($cols as $c) {
    echo "  " . $c['cid'] . ": " . $c['name'] . " (" . $c['type'] . ")\n";
}
