<?php
$cliPath = realpath(__DIR__ . '/../migration/safari-image-seed-import-cli.php');
$probeCode = 'define("WP_CLI",true);class WP_CLI{public static function add_command($name,$callback,$args=[]){}}require ' . var_export($cliPath, true) . ';echo "BOOTSTRAP-OK";';
$pipes = [];
$probe = proc_open([PHP_BINARY, '-r', $probeCode], [0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']], $pipes);
if (!is_resource($probe)) throw new RuntimeException('Could not exercise pre-bootstrap image CLI require.');
fclose($pipes[0]);
$output = stream_get_contents($pipes[1]);
$error = stream_get_contents($pipes[2]);
fclose($pipes[1]); fclose($pipes[2]);
if (proc_close($probe) !== 0 || trim((string)$output) !== 'BOOTSTRAP-OK') throw new RuntimeException('Image CLI must load safely before WordPress bootstrap: '.trim((string)$error));

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
require_once __DIR__ . '/../migration/safari-image-seed-import-cli.php';
if (!is_callable(WP_CLI::$commands['ts safari-images seed'] ?? null) || !is_callable(WP_CLI::$commands['ts safari-images rollback'] ?? null)) throw new RuntimeException('Seed and rollback commands must both be registered.');
$callback = WP_CLI::$commands['ts safari-images rollback'];
$rejected = false;
try {
    $callback([], ['backup-dir'=>'/does/not/exist','backup-id'=>'123','backup-hash'=>str_repeat('a',64),'managed-hash'=>str_repeat('b',64)]);
} catch (RuntimeException $e) {
    $rejected = str_contains($e->getMessage(), 'administrator capability and explicit confirmation');
}
if (!$rejected) throw new RuntimeException('Image rollback CLI accepted a write without explicit confirmation.');
$rejected = false;
try {
    $callback([], ['confirm-staging-write'=>'1','backup-dir'=>'/does/not/exist','backup-id'=>'123junk','backup-hash'=>str_repeat('a',64),'managed-hash'=>str_repeat('b',64)]);
} catch (RuntimeException $e) {
    $rejected = str_contains($e->getMessage(), '--backup-id');
}
if (!$rejected) throw new RuntimeException('Image rollback CLI accepted a malformed backup ID.');
echo "PASS: safari image CLI bootstrap and separately gated rollback\n";
