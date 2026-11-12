<?php
$cliPath=realpath(__DIR__.'/../migration/safari-package-import-cli.php');$probeCode='define("WP_CLI",true);class WP_CLI{public static function add_command($name,$callback,$args=[]){}}require '.var_export($cliPath,true).';echo "BOOTSTRAP-OK";';$pipes=[];$probe=proc_open([PHP_BINARY,'-r',$probeCode],[0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']],$pipes);if(!is_resource($probe))throw new RuntimeException('Could not exercise pre-bootstrap WP-CLI require.');fclose($pipes[0]);$probeOutput=stream_get_contents($pipes[1]);$probeError=stream_get_contents($pipes[2]);fclose($pipes[1]);fclose($pipes[2]);$probeStatus=proc_close($probe);if($probeStatus!==0||trim($probeOutput)!=='BOOTSTRAP-OK')throw new RuntimeException('Safari CLI must load safely before WordPress bootstrap; output: '.trim((string)$probeError));
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
