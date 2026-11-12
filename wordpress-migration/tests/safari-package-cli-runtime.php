<?php
define('ABSPATH', __DIR__ . '/wordpress-root/');
define('WP_CLI', true);
function home_url($path = '/') { return 'https://test.tanzaniasensational.com/'; }
function current_user_can($cap) { return true; }
function get_option($key) { return 0; }
class WP_CLI {
    public static $commands = [];
    public static function add_command($name, $callback, $args = []) { self::$commands[$name] = $callback; }
    public static function line($text) {}
    public static function error($message) { throw new RuntimeException($message); }
}
require_once __DIR__ . '/../migration/safari-package-import-cli.php';
$callback = WP_CLI::$commands['ts safari-packages rollback-landing'] ?? null;
if (!is_callable($callback)) throw new RuntimeException('Landing rollback CLI command was not registered.');
$rejected = false;
try {
    $callback([], [
        'confirm-staging-write' => '1',
        'backup-dir' => '/does/not/exist',
        'backup-id' => '99',
        'snapshot-hash' => str_repeat('a', 64),
    ]);
} catch (RuntimeException $e) {
    $rejected = str_contains(strtolower($e->getMessage()), 'apply');
}
if (!$rejected) throw new RuntimeException('Landing rollback CLI accepted confirmation without an explicit --apply flag.');
$rejected = false;
try {
    $callback([], [
        'apply' => '1',
        'confirm-staging-write' => '1',
        'backup-dir' => '/does/not/exist',
        'backup-id' => '99junk',
        'snapshot-hash' => str_repeat('a', 64),
    ]);
} catch (RuntimeException $e) {
    $rejected = str_contains($e->getMessage(), '--backup-id');
}
if (!$rejected) throw new RuntimeException('Landing rollback CLI accepted a non-decimal backup ID.');
echo "PASS: rollback CLI requires explicit apply and confirmation flags\n";
