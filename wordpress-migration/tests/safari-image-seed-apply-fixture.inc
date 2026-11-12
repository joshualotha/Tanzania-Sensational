<?php
function safari_image_seed_prepare_owned_landing(): string {
    $page = $GLOBALS['safari_posts'][27];
    $page->post_modified = '2026-11-12 12:00:00';
    $page->post_modified_gmt = '2026-11-12 09:00:00';
    $GLOBALS['safari_posts'][27] = $page;

    $originalPost = (array)$page;
    $originalPost['post_title'] = 'Original Safari Archive';
    $originalPost['post_content'] = 'Original editor-authored Elementor archive payload';
    ksort($originalPost);
    $elementor = '[{"widgetType":"ts_tour_archive","settings":{"count":-1,"show_cta":"yes"}}]';
    $originalMeta = ['_elementor_data'=>[$elementor], '_elementor_edit_mode'=>['builder']];
    $originalRows = [
        ['meta_key'=>'_elementor_data','meta_value'=>$elementor],
        ['meta_key'=>'_elementor_edit_mode','meta_value'=>'builder'],
    ];
    $snapshotJson = wp_json_encode(['post'=>$originalPost,'meta'=>$originalMeta,'meta_rows'=>$originalRows],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);
    $snapshotHash = hash('sha256',$snapshotJson);
    $backupPost = $originalPost;
    $backupPost['ID'] = 162;
    $backupPost['post_status'] = 'draft';
    $backupPost['post_name'] = 'safaris-preserved-backup-original';
    $GLOBALS['safari_posts'][162] = (object)$backupPost;
    $GLOBALS['safari_meta'][162] = [
        '_elementor_data'=>$elementor,
        '_elementor_edit_mode'=>'builder',
        '_ts_safari_landing_backup_snapshot'=>$snapshotJson,
        '_ts_safari_landing_backup_hash'=>$snapshotHash,
    ];
    update_post_meta(27,'_ts_safari_landing_owner','approved-safari-landing-import-v1');
    update_post_meta(27,'_ts_safari_landing_backup_id','162');
    update_post_meta(27,'_ts_safari_landing_snapshot_hash',$snapshotHash);
    $managedHash = ts_safari_landing_managed_hash(ts_safari_read_landing_page(27));
    update_post_meta(27,'_ts_safari_landing_managed_hash',$managedHash);
    return $managedHash;
}
