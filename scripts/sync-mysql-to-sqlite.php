<?php
/**
 * Sync trekking routes from live MySQL to SQLite.
 * 
 * Usage: php scripts/sync-mysql-to-sqlite.php
 * 
 * Connects to the live MySQL database, reads all tables,
 * and inserts the data into the SQLite database.
 * 
 * MySQL credentials are read directly from the .env file.
 */

$sqlitePath = __DIR__ . '/../database/database.sqlite';
$envPath = __DIR__ . '/../.env';

// Read MySQL credentials from .env
$envContent = file_get_contents($envPath);

function getEnvValue($key, $content, $default = null) {
    // Try uncommented first
    if (preg_match("/^{$key}=(.+)$/m", $content, $m)) {
        return trim($m[1]);
    }
    // Try commented
    if (preg_match("/^#\s*{$key}=(.+)$/m", $content, $m)) {
        return trim($m[1]);
    }
    return $default;
}

$mysqlHost = getEnvValue('DB_HOST', $envContent, '127.0.0.1');
$mysqlPort = getEnvValue('DB_PORT', $envContent, '3306');
$mysqlDb = getEnvValue('DB_DATABASE', $envContent, 'tanzan14_tanzania_sensetional');
$mysqlUser = getEnvValue('DB_USERNAME', $envContent, 'tanzan14_admin');
$mysqlPass = getEnvValue('DB_PASSWORD', $envContent, 'Arusha&Coconut');

echo "=== MySQL → SQLite Sync Tool ===\n\n";

// 1. Connect to MySQL
echo "Connecting to MySQL: {$mysqlHost}:{$mysqlPort}/{$mysqlDb}\n";
try {
    $mysql = new PDO(
        "mysql:host={$mysqlHost};port={$mysqlPort};dbname={$mysqlDb};charset=utf8mb4",
        $mysqlUser,
        $mysqlPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✓ MySQL connected\n";
} catch (PDOException $e) {
    echo "✗ MySQL connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// 2. Connect to SQLite
echo "Connecting to SQLite: {$sqlitePath}\n";
if (!file_exists($sqlitePath)) {
    echo "✗ SQLite database not found. Run 'touch database/database.sqlite && php artisan migrate --force' first.\n";
    exit(1);
}
try {
    $sqlite = new PDO("sqlite:{$sqlitePath}");
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlite->exec('PRAGMA foreign_keys = OFF');
    $sqlite->exec('PRAGMA journal_mode = MEMORY');
    $sqlite->exec('PRAGMA synchronous = OFF');
    echo "✓ SQLite connected\n";
} catch (PDOException $e) {
    echo "✗ SQLite connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// 3. Get list of tables to sync
$tables = [
    'trekking_routes',
    'route_itinerary_days',
    'departures',
    'pricing_rules',
    'destinations',
    'safari_packages',
    'blog_posts',
    'pages',
    'site_settings',
    'visual_assets',
    'gear_items',
];

foreach ($tables as $table) {
    echo "\n--- Processing: {$table} ---\n";
    
    // Check if table exists in MySQL
    $stmt = $mysql->query("SHOW TABLES LIKE '{$table}'");
    if (!$stmt->fetch()) {
        echo "  Skipping: table '{$table}' not found in MySQL\n";
        continue;
    }
    
    // Check if table exists in SQLite
    $stmt = $sqlite->query("SELECT name FROM sqlite_master WHERE type='table' AND name='{$table}'");
    if (!$stmt->fetch()) {
        echo "  Skipping: table '{$table}' not found in SQLite\n";
        continue;
    }
    
    // Get column info from SQLite
    $stmt = $sqlite->query("PRAGMA table_info(`{$table}`)");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $columnNames = array_column($columns, 'name');
    
    if (empty($columnNames)) {
        echo "  Skipping: no columns found for '{$table}'\n";
        continue;
    }
    
    // Fetch all data from MySQL
    $colList = '`' . implode('`,`', $columnNames) . '`';
    $stmt = $mysql->query("SELECT {$colList} FROM `{$table}`");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($rows)) {
        echo "  No data in MySQL for '{$table}'\n";
        continue;
    }
    
    echo "  Found " . count($rows) . " rows in MySQL\n";
    
    // Clear existing data in SQLite
    $sqlite->exec("DELETE FROM `{$table}`");
    
    // Insert data into SQLite
    $placeholders = '(' . implode(',', array_fill(0, count($columnNames), '?')) . ')';
    $insertStmt = $sqlite->prepare("INSERT INTO `{$table}` ({$colList}) VALUES {$placeholders}");
    
    $inserted = 0;
    $errors = 0;
    
    foreach ($rows as $row) {
        $values = [];
        foreach ($columnNames as $col) {
            $values[] = $row[$col] ?? null;
        }
        
        try {
            $insertStmt->execute($values);
            $inserted++;
        } catch (PDOException $e) {
            $errors++;
            if ($errors <= 3) {
                echo "  Error: " . $e->getMessage() . "\n";
            }
        }
    }
    
    echo "  Inserted {$inserted} rows into SQLite" . ($errors ? " ({$errors} errors)" : "") . "\n";
}

echo "\n=== Sync complete! ===\n";
echo "Run 'php artisan optimize:clear' to clear cached config, then test the site.\n";
