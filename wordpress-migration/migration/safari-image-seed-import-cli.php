<?php
if (!defined('WP_CLI') || !WP_CLI) { return; }
WP_CLI::add_command('ts safari-images seed', static function($args,$assoc) {
    require_once __DIR__ . '/safari-package-importer.php';
    try {
        $apply=ts_safari_parse_cli_flag($assoc,'apply'); $confirm=ts_safari_parse_cli_flag($assoc,'confirm-staging-write');
        $hash=(string)($assoc['managed-hash']??'');
        if($apply&&!preg_match('/^[a-f0-9]{64}$/',$hash))throw new RuntimeException('Safari image seed apply requires --managed-hash copied from dry-run.');
        if(!$apply&&$hash!==''&&!preg_match('/^[a-f0-9]{64}$/',$hash))throw new RuntimeException('--managed-hash must be lowercase SHA-256 when supplied.');
        ts_safari_validate_run_mode($apply,$confirm,current_user_can('manage_options'),home_url('/'),get_option('blog_public'));
        if($apply){$backup=(string)($assoc['backup-dir']??'');if($backup==='')throw new RuntimeException('Safari image seed apply requires a verified private backup directory.');ts_safari_verify_backup($backup);}
        $manifest=json_decode((string)file_get_contents(__DIR__.'/safari-image-seed-manifest.json'),true,512,JSON_THROW_ON_ERROR);
        $landing=json_decode((string)file_get_contents(__DIR__.'/safari-landing-manifest.json'),true,512,JSON_THROW_ON_ERROR);
        $result=$apply?ts_safari_image_seed_apply($manifest,$landing,$hash):ts_safari_image_seed_plan($manifest,$landing,$hash);
        WP_CLI::line(wp_json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    } catch(Throwable $e) { WP_CLI::error($e->getMessage()); }
}, ['shortdesc'=>'Plan or staging-gated apply of exact live safari images.']);

WP_CLI::add_command('ts safari-images rollback', static function($args,$assoc) {
    require_once __DIR__ . '/safari-package-importer.php';
    try {
        $confirm=ts_safari_parse_cli_flag($assoc,'confirm-staging-write');
        $backupDir=(string)($assoc['backup-dir']??'');$backupIdRaw=(string)($assoc['backup-id']??'');$backupHash=(string)($assoc['backup-hash']??'');$managedHash=(string)($assoc['managed-hash']??'');
        if($backupDir==='')throw new RuntimeException('Safari image rollback requires a verified private backup directory.');
        if(!preg_match('/^[1-9][0-9]*$/',$backupIdRaw)||!preg_match('/^[a-f0-9]{64}$/',$backupHash)||!preg_match('/^[a-f0-9]{64}$/',$managedHash))throw new RuntimeException('Safari image rollback requires exact --backup-id, --backup-hash, and --managed-hash values from the verified apply read-back.');
        ts_safari_validate_run_mode(true,$confirm,current_user_can('manage_options'),home_url('/'),get_option('blog_public'));
        ts_safari_verify_backup($backupDir);
        $manifest=json_decode((string)file_get_contents(__DIR__.'/safari-image-seed-manifest.json'),true,512,JSON_THROW_ON_ERROR);
        $landing=json_decode((string)file_get_contents(__DIR__.'/safari-landing-manifest.json'),true,512,JSON_THROW_ON_ERROR);
        $result=ts_safari_image_seed_rollback($manifest,$landing,(int)$backupIdRaw,$backupHash,$managedHash);
        WP_CLI::line(wp_json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    } catch(Throwable $e) { WP_CLI::error($e->getMessage()); }
}, ['shortdesc'=>'Separately gated rollback of a verified staging image seed.']);
