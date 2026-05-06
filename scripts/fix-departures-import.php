<?php
/**
 * Fix the departures table data that was imported with wrong column order.
 * 
 * The MySQL dump has columns in this order:
 *   id, trekking_route_id, departure_date, return_date, price_cents, 
 *   total_seats, available_seats, booked_seats, held_seats, status,
 *   summit_night, meeting_point, briefing_date, description, 
 *   inclusions, exclusions, created_at, updated_at
 * 
 * But the SQLite schema (from migrations) has total_seats and held_seats
 * at the END because they were added in a later migration.
 * 
 * Usage: php scripts/fix-departures-import.php
 */

$sqlitePath = __DIR__ . '/../database/database.sqlite';
$dumpPath = __DIR__ . '/../final.sql';

if (!file_exists($dumpPath)) {
    echo "ERROR: Dump file not found at {$dumpPath}\n";
    exit(1);
}

if (!file_exists($sqlitePath)) {
    echo "ERROR: SQLite database not found at {$sqlitePath}\n";
    exit(1);
}

echo "Opening SQLite database: {$sqlitePath}\n";
$db = new PDO("sqlite:{$sqlitePath}");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = OFF');

echo "Reading dump file: {$dumpPath}\n";
$dump = file_get_contents($dumpPath);

// Extract only the departures INSERT statement
preg_match('/INSERT INTO `departures` VALUES\s*(.*?);\s*$/sm', $dump, $match);

if (empty($match)) {
    echo "ERROR: Could not find departures INSERT in dump\n";
    exit(1);
}

$valuesBlock = $match[1];

/**
 * Parse the VALUES block from a MySQL INSERT statement.
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

function convertMysqlValue(string $value, string $columnType): mixed
{
    $value = trim($value);
    
    if (strtoupper($value) === 'NULL') {
        return null;
    }
    
    if (strtoupper($value) === 'TRUE') {
        return 1;
    }
    if (strtoupper($value) === 'FALSE') {
        return 0;
    }
    
    if (preg_match('/^0x[0-9a-fA-F]+$/', $value)) {
        return hex2bin(substr($value, 2));
    }
    
    if ((str_starts_with($value, "'") && str_ends_with($value, "'")) ||
        (str_starts_with($value, '"') && str_ends_with($value, '"'))) {
        $inner = substr($value, 1, -1);
        $inner = str_replace(
            ["\\'", '\\"', '\\\\', '\\n', '\\r', '\\t', '\\0', '\\Z', '\\b'],
            ["'", '"', '\\', "\n", "\r", "\t", "\0", "\x1a", "\x08"],
            $inner
        );
        $inner = preg_replace('/\\\\(.)/', '$1', $inner);
        return $inner;
    }
    
    if (is_numeric($value)) {
        if (str_contains($value, '.')) {
            return (float) $value;
        }
        return (int) $value;
    }
    
    return $value;
}

echo "Parsing departures data from MySQL dump...\n";
$rows = parseValuesBlock($valuesBlock);
echo "Found " . count($rows) . " departure rows\n";

// MySQL dump column order (18 columns):
// 0:id, 1:trekking_route_id, 2:departure_date, 3:return_date, 4:price_cents,
// 5:total_seats, 6:available_seats, 7:booked_seats, 8:held_seats, 9:status,
// 10:summit_night, 11:meeting_point, 12:briefing_date, 13:description,
// 14:inclusions, 15:exclusions, 16:created_at, 17:updated_at

// SQLite column order (18 columns):
// 0:id, 1:trekking_route_id, 2:departure_date, 3:return_date, 4:price_cents,
// 5:available_seats, 6:booked_seats, 7:status, 8:summit_night, 9:meeting_point,
// 10:briefing_date, 11:description, 12:inclusions, 13:exclusions,
// 14:created_at, 15:updated_at, 16:total_seats, 17:held_seats

// Mapping: MySQL position => SQLite position
$mapping = [
    0 => 0,   // id => id
    1 => 1,   // trekking_route_id => trekking_route_id
    2 => 2,   // departure_date => departure_date
    3 => 3,   // return_date => return_date
    4 => 4,   // price_cents => price_cents
    5 => 16,  // total_seats => total_seats (moved to end in SQLite)
    6 => 5,   // available_seats => available_seats
    7 => 6,   // booked_seats => booked_seats
    8 => 17,  // held_seats => held_seats (moved to end in SQLite)
    9 => 7,   // status => status
    10 => 8,  // summit_night => summit_night
    11 => 9,  // meeting_point => meeting_point
    12 => 10, // briefing_date => briefing_date
    13 => 11, // description => description
    14 => 12, // inclusions => inclusions
    15 => 13, // exclusions => exclusions
    16 => 14, // created_at => created_at
    17 => 15, // updated_at => updated_at
];

// SQLite column types for convertMysqlValue
$sqliteTypes = [
    0 => 'INTEGER',    // id
    1 => 'INTEGER',    // trekking_route_id
    2 => 'date',       // departure_date
    3 => 'date',       // return_date
    4 => 'INTEGER',    // price_cents
    5 => 'INTEGER',    // available_seats
    6 => 'INTEGER',    // booked_seats
    7 => 'varchar',    // status
    8 => 'varchar',    // summit_night
    9 => 'varchar',    // meeting_point
    10 => 'varchar',   // briefing_date
    11 => 'TEXT',      // description
    12 => 'TEXT',      // inclusions
    13 => 'TEXT',      // exclusions
    14 => 'datetime',  // created_at
    15 => 'datetime',  // updated_at
    16 => 'INTEGER',   // total_seats
    17 => 'INTEGER',   // held_seats
];

// Delete existing departures data
echo "Clearing existing departures data...\n";
$db->exec('DELETE FROM departures');

// Insert with correct column mapping
echo "Re-inserting departures with correct column mapping...\n";

$sqliteColumns = [
    'id', 'trekking_route_id', 'departure_date', 'return_date', 'price_cents',
    'available_seats', 'booked_seats', 'status', 'summit_night', 'meeting_point',
    'briefing_date', 'description', 'inclusions', 'exclusions',
    'created_at', 'updated_at', 'total_seats', 'held_seats'
];

$colList = '`' . implode('`,`', $sqliteColumns) . '`';
$placeholders = '(' . implode(',', array_fill(0, count($sqliteColumns), '?')) . ')';

$insertStmt = $db->prepare("INSERT INTO `departures` ({$colList}) VALUES {$placeholders}");

$inserted = 0;
foreach ($rows as $mysqlRow) {
    $sqliteRow = [];
    for ($sqlitePos = 0; $sqlitePos < count($sqliteColumns); $sqlitePos++) {
        // Find which MySQL position maps to this SQLite position
        $mysqlPos = array_search($sqlitePos, $mapping);
        if ($mysqlPos !== false && isset($mysqlRow[$mysqlPos])) {
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
        echo "  Row: " . json_encode($sqliteRow) . "\n";
    }
}

$db->exec('PRAGMA foreign_keys = ON');

echo "\n========================================\n";
echo "FIX COMPLETE\n";
echo "Re-inserted {$inserted} departure rows with correct column mapping\n";
echo "========================================\n";

// Verify
echo "\nVerification:\n";
$stmt = $db->query('SELECT id, trekking_route_id, departure_date, return_date, price_cents, total_seats, available_seats, booked_seats, held_seats, status FROM departures LIMIT 5');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "  " . json_encode($row) . "\n";
}
