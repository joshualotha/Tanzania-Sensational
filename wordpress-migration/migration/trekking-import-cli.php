<?php
/** Strict WP-CLI wrapper; dry-run is the default. */
if (!class_exists('WP_CLI')) throw new RuntimeException('Load through WP-CLI after WordPress bootstrap.');
function ts_trek_wp_cli_import(array $args,array $opts): void {
    if ($args) WP_CLI::error('Positional arguments are not accepted.');
    $allowed=['apply','confirm-staging-write','backup-dir'];
    if (array_diff(array_keys($opts),$allowed)) WP_CLI::error('Unexpected importer option.');
    foreach(['apply','confirm-staging-write'] as $flag) if(array_key_exists($flag,$opts)&&$opts[$flag]!==true) WP_CLI::error('--'.$flag.' must be a bare flag.');
    $apply=array_key_exists('apply',$opts);$confirm=array_key_exists('confirm-staging-write',$opts);$backup=$opts['backup-dir']??'';
    if(!is_string($backup)) WP_CLI::error('--backup-dir must be a path.');
    if($apply&&(!$confirm||$backup==='')) WP_CLI::error('Apply requires --confirm-staging-write and --backup-dir.');
    if(!$apply&&($confirm||$backup!=='')) WP_CLI::error('Confirmation and backup path are only accepted with --apply.');
    require_once __DIR__.'/trekking-importer.php';
    try {$result=ts_trek_import_run($apply,$confirm,$backup);WP_CLI::log(wp_json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));}
    catch(Throwable $e){WP_CLI::error($e->getMessage());}
    WP_CLI::success($apply?'Staging route import completed and verified.':'Read-only dry-run completed.');
}
WP_CLI::add_command('ts trek-routes import','ts_trek_wp_cli_import');
