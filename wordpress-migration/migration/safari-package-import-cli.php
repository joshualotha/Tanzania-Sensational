<?php
if (!defined('WP_CLI') || !WP_CLI) { return; }
require_once __DIR__ . '/safari-package-importer.php';
WP_CLI::add_command('ts safari-packages rollback-landing', static function($args,$assoc) {
    try {
        $apply=ts_safari_parse_cli_flag($assoc,'apply');
        $confirm=ts_safari_parse_cli_flag($assoc,'confirm-staging-write');
        ts_safari_validate_run_mode($apply,$confirm,current_user_can('manage_options'),home_url('/'),get_option('blog_public'));
        $backupId=(string)($assoc['backup-id']??'');
        $snapshotHash=(string)($assoc['snapshot-hash']??'');
        if(!preg_match('/^[1-9][0-9]*$/',$backupId))throw new RuntimeException('Safari rollback --backup-id must be a positive decimal post ID.');
        if(!preg_match('/^[a-f0-9]{64}$/',$snapshotHash))throw new RuntimeException('Safari rollback --snapshot-hash must be a lowercase SHA-256 digest.');
        if(!$apply||!$confirm||empty($assoc['backup-dir']))throw new RuntimeException('Safari rollback requires --apply, --confirm-staging-write, verified backup, backup ID, and snapshot hash.');
        ts_safari_verify_backup((string)$assoc['backup-dir']);
        $result=ts_safari_rollback_landing(27,(int)$backupId,$snapshotHash);
        WP_CLI::line(wp_json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    } catch(Throwable $e) { WP_CLI::error($e->getMessage()); }
}, ['shortdesc'=>'Restore page 27 from its verified private draft clone.']);
WP_CLI::add_command('ts safari-packages import', static function($args,$assoc) {
    try {
        $apply=ts_safari_parse_cli_flag($assoc,'apply'); $confirm=ts_safari_parse_cli_flag($assoc,'confirm-staging-write'); $backup=(string)($assoc['backup-dir']??'');
        $landingHash=(string)($assoc['landing-snapshot-hash']??'');
        $result=ts_safari_import_run($apply,$confirm,$backup,$landingHash);
        WP_CLI::line(wp_json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    } catch(Throwable $e) { WP_CLI::error($e->getMessage()); }
}, ['shortdesc'=>'Preflight or apply the two source-backed safari packages and guarded landing route.']);
