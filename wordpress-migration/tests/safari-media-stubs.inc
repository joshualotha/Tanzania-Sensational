<?php
if (!isset($GLOBALS['safari_upload_root'])) {
    $base = getenv('TMPDIR') ?: '/home/hermes/.hermes/cache/scratch';
    $GLOBALS['safari_upload_root'] = $base . '/safari-media-test-' . bin2hex(random_bytes(6));
    if (!mkdir($GLOBALS['safari_upload_root'], 0700, true)) throw new RuntimeException('Could not create isolated media test directory.');
    register_shutdown_function(static function (): void {
        foreach (glob($GLOBALS['safari_upload_root'] . '/*') ?: [] as $file) if (is_file($file)) @unlink($file);
        @rmdir($GLOBALS['safari_upload_root']);
    });
}
$GLOBALS['safari_attachment_files'] = $GLOBALS['safari_attachment_files'] ?? [];
$GLOBALS['safari_http_calls'] = $GLOBALS['safari_http_calls'] ?? [];
$GLOBALS['safari_http_response'] = $GLOBALS['safari_http_response'] ?? [
    'response' => ['code' => 200],
    'headers' => ['content-type' => 'image/jpeg'],
    'body' => file_get_contents(__DIR__ . '/fixtures/safari-hero.jpg'),
];
if (!function_exists('wp_remote_get')) {
    function wp_remote_get($url, $args = []) {
        $GLOBALS['safari_http_calls'][] = ['url' => $url, 'args' => $args];
        return $GLOBALS['safari_http_response'];
    }
}
if (!function_exists('wp_safe_remote_get')) {
    function wp_safe_remote_get($url, $args = []) { return wp_remote_get($url, $args); }
}
if (!function_exists('wp_remote_retrieve_response_code')) {
    function wp_remote_retrieve_response_code($response) { return $response['response']['code'] ?? 0; }
}
if (!function_exists('wp_remote_retrieve_header')) {
    function wp_remote_retrieve_header($response, $name) { return $response['headers'][strtolower($name)] ?? ''; }
}
if (!function_exists('wp_remote_retrieve_body')) {
    function wp_remote_retrieve_body($response) { return $response['body'] ?? ''; }
}
if (!function_exists('wp_tempnam')) {
    function wp_tempnam($filename = '') { return tempnam($GLOBALS['safari_upload_root'], 'upload-'); }
}
if (!function_exists('sanitize_file_name')) {
    function sanitize_file_name($name) { return preg_replace('/[^A-Za-z0-9._-]/', '-', $name); }
}
if (!function_exists('wp_handle_sideload')) {
    function wp_handle_sideload(&$file, $overrides = []) {
        if (!empty($GLOBALS['safari_throw_sideload'])) throw new RuntimeException('Injected sideload API failure.');
        $target = $GLOBALS['safari_upload_root'] . '/' . sanitize_file_name($file['name']);
        if (file_exists($target)) $target = $GLOBALS['safari_upload_root'] . '/' . bin2hex(random_bytes(4)) . '-' . sanitize_file_name($file['name']);
        if (!rename($file['tmp_name'], $target)) return ['error' => 'rename failed'];
        return ['file' => $target, 'url' => 'https://test.invalid/uploads/' . basename($target), 'type' => 'image/jpeg'];
    }
}
if (!function_exists('wp_insert_attachment')) {
    function wp_insert_attachment($post, $file, $parent = 0, $wp_error = false) {
        if (!empty($GLOBALS['safari_fail_attachment_insert'])) return 0;
        $id = ++$GLOBALS['safari_next'];
        $status=$post['post_status']??'inherit';if($status==='draft')$status='inherit';
        $GLOBALS['safari_posts'][$id] = (object) (['ID' => $id, 'post_type' => 'attachment', 'post_status' => $status, 'post_parent' => $parent] + $post);
        $GLOBALS['safari_attachment_files'][$id] = $file;
        return $id;
    }
}
if (!function_exists('get_attached_file')) {
    function get_attached_file($id) { return $GLOBALS['safari_attachment_files'][$id] ?? false; }
}
if (!function_exists('wp_delete_attachment')) {
    function wp_delete_attachment($id, $force = false) {
        if (!empty($GLOBALS['safari_fail_attachment_delete'])) return false;
        $file = get_attached_file($id);
        if ($file && is_file($file) && !unlink($file)) return false;
        unset($GLOBALS['safari_attachment_files'][$id], $GLOBALS['safari_posts'][$id], $GLOBALS['safari_fields'][$id], $GLOBALS['safari_meta'][$id]);
        return true;
    }
}
if (!function_exists('add_post_meta')) {
    function add_post_meta($id, $key, $value, $unique = false) {
        if ($unique && isset($GLOBALS['safari_meta'][$id][$key])) return false;
        $GLOBALS['safari_meta'][$id][$key] = unslash($value);
        return true;
    }
}
if (!function_exists('wp_generate_attachment_metadata')) {
    function wp_generate_attachment_metadata($id, $file) { $image=getimagesize($file); $thumb=dirname($file).'/thumb-'.basename($file); if(!copy($file,$thumb))return false; $metadata=['file' => basename($file), 'width' => $image[0] ?? 0, 'height' => $image[1] ?? 0, 'sizes' => ['thumbnail'=>['file'=>basename($thumb)]]];if(!empty($GLOBALS['safari_premature_attachment_metadata']))$GLOBALS['safari_meta'][$id]['_wp_attachment_metadata']=$metadata;return $metadata; }
}
if (!function_exists('wp_upload_dir')) {
    function wp_upload_dir($time = null, $create_dir = true, $refresh_cache = false) { return ['basedir' => $GLOBALS['safari_upload_root'], 'baseurl' => 'https://test.invalid/uploads', 'path' => $GLOBALS['safari_upload_root'], 'url' => 'https://test.invalid/uploads', 'error' => false]; }
}
if (!function_exists('wp_get_attachment_metadata')) {
    function wp_get_attachment_metadata($id) { return $GLOBALS['safari_meta'][$id]['_wp_attachment_metadata'] ?? false; }
}
if (!function_exists('wp_update_attachment_metadata')) {
    function wp_update_attachment_metadata($id, $metadata) { if(!empty($GLOBALS['safari_fail_attachment_metadata_update']))return false;if(($GLOBALS['safari_meta'][$id]['_wp_attachment_metadata']??null)===$metadata)return false;return update_post_meta($id, '_wp_attachment_metadata', $metadata); }
}
