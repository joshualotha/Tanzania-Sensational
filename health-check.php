<?php
// Health check file for CPanel deployment debugging
// This file tests if Laravel can bootstrap successfully

header('Content-Type: text/plain');

echo "=== Tanzania Sensational Health Check ===\n\n";

// Test 1: PHP Version
echo "1. PHP Version: " . PHP_VERSION . "\n";
$requiredPhp = '8.2.0';
if (version_compare(PHP_VERSION, $requiredPhp, '>=')) {
    echo "   ✓ PHP version meets requirement (>= $requiredPhp)\n";
} else {
    echo "   ✗ PHP version too low. Required: >= $requiredPhp\n";
}

// Test 2: Required PHP extensions
$requiredExtensions = ['pdo', 'mbstring', 'tokenizer', 'xml', 'ctype', 'json', 'openssl', 'fileinfo'];
echo "\n2. PHP Extensions:\n";
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        echo "   ✓ $ext\n";
    } else {
        echo "   ✗ $ext (MISSING)\n";
    }
}

// Test 3: File permissions
echo "\n3. File Permissions:\n";
$directories = [
    'storage' => 'Storage directory',
    'storage/framework' => 'Framework cache',
    'storage/logs' => 'Logs directory',
    'bootstrap/cache' => 'Bootstrap cache'
];

foreach ($directories as $dir => $label) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "   ✓ $label is writable\n";
        } else {
            echo "   ✗ $label is NOT writable\n";
        }
    } else {
        echo "   ✗ $label does not exist\n";
    }
}

// Test 4: Vendor directory
echo "\n4. Dependencies:\n";
if (is_dir('vendor') && file_exists('vendor/autoload.php')) {
    echo "   ✓ Vendor directory exists\n";
    
    // Try to load composer autoload
    try {
        require_once 'vendor/autoload.php';
        echo "   ✓ Composer autoload loaded successfully\n";
    } catch (Exception $e) {
        echo "   ✗ Failed to load composer autoload: " . $e->getMessage() . "\n";
    }
} else {
    echo "   ✗ Vendor directory missing or incomplete\n";
}

// Test 5: Laravel bootstrap
echo "\n5. Laravel Bootstrap:\n";
if (file_exists('bootstrap/app.php')) {
    echo "   ✓ bootstrap/app.php exists\n";
    
    // Try to require the bootstrap file
    try {
        define('LARAVEL_START', microtime(true));
        
        if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
            require $maintenance;
        }
        
        if (file_exists('vendor/autoload.php')) {
            require 'vendor/autoload.php';
            
            $app = require_once 'bootstrap/app.php';
            echo "   ✓ Laravel application bootstrapped successfully\n";
            
            // Test environment
            echo "   ✓ Application environment: " . ($app->environment() ?: 'Not set') . "\n";
        } else {
            echo "   ✗ Cannot bootstrap - vendor/autoload.php missing\n";
        }
    } catch (Throwable $e) {
        echo "   ✗ Laravel bootstrap failed: " . $e->getMessage() . "\n";
        echo "     Error type: " . get_class($e) . "\n";
        if ($e->getPrevious()) {
            echo "     Previous error: " . $e->getPrevious()->getMessage() . "\n";
        }
    }
} else {
    echo "   ✗ bootstrap/app.php not found\n";
}

// Test 6: .env file
echo "\n6. Environment Configuration:\n";
if (file_exists('.env')) {
    echo "   ✓ .env file exists\n";
    
    // Check for APP_KEY
    $envContent = file_get_contents('.env');
    if (strpos($envContent, 'APP_KEY=') !== false) {
        echo "   ✓ APP_KEY is set\n";
    } else {
        echo "   ✗ APP_KEY is not set\n";
    }
} else {
    echo "   ✗ .env file not found\n";
}

echo "\n=== Health Check Complete ===\n";
echo "\nInstructions:\n";
echo "1. Upload phpinfo.php and health-check.php to your CPanel\n";
echo "2. Visit https://yourdomain.com/phpinfo.php to check PHP configuration\n";
echo "3. Visit https://yourdomain.com/health-check.php to diagnose Laravel issues\n";
echo "4. Remove these files after debugging for security\n";

?>