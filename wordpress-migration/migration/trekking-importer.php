<?php
/** Staging-only create-only importer for verified trekking routes. */
function ts_trek_approved_slugs(): array { return ['lemosho-7-days','lemosho-8-days','lemosho-8-days-crater','machame-6-days','machame-7-days','marangu-5-days','marangu-6-days','mt-meru-3-days','mt-meru-4-days','northern-circuit-8-days','northern-circuit-9-days','northern-circuit-9-days-crater','rongai-6-days','rongai-7-days','umbwe-6-days','umbwe-7-days']; }
function ts_trek_hash(array $v): string { return hash('sha256',json_encode($v,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR)); }
function ts_trek_assert_snapshot_matches_expected(array $saved, array $expected): void { if (!hash_equals(ts_trek_hash($expected), ts_trek_hash($saved))) throw new RuntimeException('Saved ownership snapshot does not match the approved manifest.'); }
function ts_trek_normalize_field(string $name, $value) { if (in_array($name, ['ts_trek_featured','ts_trek_display_order'], true)) return (int)($value ?: 0); if (in_array($name, ['ts_trek_highlights','ts_trek_itinerary','ts_trek_inclusions','ts_trek_exclusions','ts_trek_gallery_urls'], true)) return is_array($value) ? $value : []; return $value === null || $value === false ? '' : (is_scalar($value) ? (string)$value : $value); }
function ts_trek_expected_state(array $r, string $status='publish'): array {
    $fields = [];
    foreach (ts_trek_expected_fields($r) as $name => $value) $fields[$name] = ts_trek_normalize_field($name, $value);
    return ['post_type'=>'ts_trek_route','post_status'=>$status,'post_name'=>$r['slug'],'post_title'=>$r['title'],'post_content'=>'','fields'=>$fields];
}
function ts_trek_validate_manifest(array $m): void {
 if(($m['schema_version']??null)!==1||!is_array($m['routes']??null)||count($m['routes'])!==16)throw new RuntimeException('Manifest must contain exactly 16 approved routes.');
 $seen=[];$seen_source_ids=[];$allow=['source_id','slug','source_url','title','duration','difficulty','description','route_family','duration_variant','hero_image_url','hero_image_alt','price','success_rate','overview_edit_note'];
 foreach($m['routes'] as $r){if(!is_array($r)||array_diff(array_diff(array_keys($r),['overview_edit_note']),$allow)||array_diff(array_diff($allow,['overview_edit_note']),array_keys($r)))throw new RuntimeException('Route fields exceed approved scope.');$s=$r['slug'];if(!in_array($s,ts_trek_approved_slugs(),true)||isset($seen[$s]))throw new RuntimeException('Unapproved or duplicate route.');$seen[$s]=1;
 $u=parse_url($r['source_url']);$im=parse_url($r['hero_image_url']);if(($u['scheme']??'')!=='https'||($u['host']??'')!=='tanzaniasensational.com'||($u['path']??'')!=='/trekking/kilimanjaro/'.$r['slug']||isset($u['query'])||isset($u['fragment']))throw new RuntimeException('Invalid source listing URL.');if(($im['scheme']??'')!=='https'||($im['host']??'')!=='tanzaniasensational.com'||!preg_match('/\.jpe?g$/i',(string)($im['path']??'')))throw new RuntimeException('Invalid hero image URL.');
 if(isset($r['overview_edit_note'])&&trim((string)$r['overview_edit_note'])==='')throw new RuntimeException('Overview edits require a reason.');if(preg_match('/(?:success\\s+rate|gold standard for success|higher success|highest success|success at the)/i',(string)$r['description']))throw new RuntimeException('Overview contains an unverified success claim.');
 $family=str_starts_with($s,'mt-meru-')?'Mount Meru':(str_starts_with($s,'northern-circuit-')?'Northern Circuit':ucfirst(explode('-',$s)[0]));if(!is_int($r['source_id'])||$r['source_id']<1||isset($seen_source_ids[$r['source_id']])||!is_int($r['duration'])||$r['duration']<1||trim($r['title'])===''||trim($r['description'])===''||trim($r['difficulty'])===''||$r['route_family']!==$family||$r['duration_variant']!==$r['duration'].' days'||$r['price']!==''||$r['success_rate']!==''||$r['hero_image_alt']!=='Trekking route: '.$r['title'])throw new RuntimeException('Invalid verified route data or blank fields.');$seen_source_ids[$r['source_id']]=true;}
 if(array_keys($seen)!==ts_trek_approved_slugs())throw new RuntimeException('Manifest route list/order is not approved.');
}
function ts_trek_expected_fields(array $r): array {return ['ts_trek_route_family'=>$r['route_family'],'ts_trek_duration_variant'=>$r['duration_variant'],'ts_trek_duration'=>$r['duration'].' days','ts_trek_difficulty'=>$r['difficulty'],'ts_trek_distance'=>'','ts_trek_elevation_gain'=>'','ts_trek_success_rate'=>'','ts_trek_accommodation_style'=>'','ts_trek_base_price'=>'','ts_trek_currency'=>'','ts_trek_featured'=>0,'ts_trek_display_order'=>0,'ts_trek_hero_image_url'=>$r['hero_image_url'],'ts_trek_hero_image_alt'=>$r['hero_image_alt'],'ts_trek_editorial_image_url'=>'','ts_trek_gallery_urls'=>[],'ts_trek_overview'=>$r['description'],'ts_trek_highlights'=>[],'ts_trek_itinerary'=>[],'ts_trek_inclusions'=>[],'ts_trek_exclusions'=>[],'ts_trek_source_url'=>$r['source_url'],'ts_trek_meta_title'=>$r['title'],'ts_trek_meta_description'=>''];}
function ts_trek_required_acf_schema(): array
{
    return [
        'ts_trek_duration'=>['type'=>'text'],'ts_trek_route_family'=>['type'=>'text'],
        'ts_trek_duration_variant'=>['type'=>'text'],'ts_trek_difficulty'=>['type'=>'text'],
        'ts_trek_distance'=>['type'=>'text'],'ts_trek_elevation_gain'=>['type'=>'text'],
        'ts_trek_success_rate'=>['type'=>'text'],'ts_trek_accommodation_style'=>['type'=>'text'],
        'ts_trek_base_price'=>['type'=>'number'],'ts_trek_currency'=>['type'=>'text'],
        'ts_trek_featured'=>['type'=>'true_false'],'ts_trek_display_order'=>['type'=>'number'],
        'ts_trek_hero_image_url'=>['type'=>'url'],'ts_trek_hero_image_alt'=>['type'=>'text'],
        'ts_trek_editorial_image_url'=>['type'=>'url'],'ts_trek_gallery_urls'=>['type'=>'repeater','sub_fields'=>['url'=>'url','alt'=>'text']],
        'ts_trek_overview'=>['type'=>'wysiwyg'],'ts_trek_highlights'=>['type'=>'repeater','sub_fields'=>['text'=>'text']],
        'ts_trek_itinerary'=>['type'=>'repeater','sub_fields'=>['day'=>'number','title'=>'text','description'=>'textarea','elevation'=>'text','distance'=>'text','habitat'=>'text','meals'=>'text','camp'=>'text']],
        'ts_trek_inclusions'=>['type'=>'repeater','sub_fields'=>['text'=>'text']],
        'ts_trek_exclusions'=>['type'=>'repeater','sub_fields'=>['text'=>'text']],
        'ts_trek_source_url'=>['type'=>'url'],'ts_trek_meta_title'=>['type'=>'text'],
        'ts_trek_meta_description'=>['type'=>'textarea'],
    ];
}

function ts_trek_validate_acf_schema(callable $field_lookup): void
{
    foreach (ts_trek_required_acf_schema() as $name => $expected) {
        $key = 'field_'.$name;
        $field = $field_lookup($key);
        if (!is_array($field) || ($field['key'] ?? null) !== $key || ($field['name'] ?? null) !== $name
            || ($field['type'] ?? null) !== $expected['type']) {
            throw new RuntimeException('Required trekking ACF field schema is missing or changed: '.$name);
        }
        if (!isset($expected['sub_fields'])) continue;
        $actual = [];
        foreach (($field['sub_fields'] ?? []) as $sub_field) {
            if (!is_array($sub_field) || !is_string($sub_field['name'] ?? null) || !is_string($sub_field['type'] ?? null)
                || array_key_exists($sub_field['name'], $actual)) throw new RuntimeException('Invalid trekking ACF repeater schema: '.$name);
            $actual[$sub_field['name']] = $sub_field['type'];
        }
        $expected_subfields = $expected['sub_fields'];
        ksort($actual); ksort($expected_subfields);
        if ($actual !== $expected_subfields) throw new RuntimeException('Trekking ACF repeater sub-fields are missing or changed: '.$name);
    }
}

function ts_trek_expected_template_conditions(): array{return ['include/singular/ts_trek_route'];}
function ts_trek_template_conditions_api(): array
{
    return array_map(static fn(string $condition): array => explode('/', $condition), ts_trek_expected_template_conditions());
}

function ts_trek_template_elementor_data(): array
{
    return [['id'=>'tstrk001','elType'=>'section','settings'=>[],'elements'=>[['id'=>'tstrk002','elType'=>'column','settings'=>[],'elements'=>[['id'=>'tstrk003','elType'=>'widget','widgetType'=>'ts_single_trek_route','settings'=>[],'elements'=>[]]]]]]];
}

function ts_trek_expected_template_state(?string $elementor_version = null): array
{
    $version = $elementor_version ?? (defined('ELEMENTOR_VERSION') ? (string)ELEMENTOR_VERSION : 'unknown');
    return [
        'post_type'=>'elementor_library','post_status'=>'publish','post_name'=>'ts-single-trek-route',
        'post_title'=>'TS Single Trekking Route','post_content'=>'','template_type'=>'single',
        'edit_mode'=>'builder','elementor_version'=>$version,'page_settings'=>[],
        'elementor_data'=>ts_trek_template_elementor_data(),'widget_type'=>'ts_single_trek_route',
        'conditions'=>ts_trek_expected_template_conditions(),
    ];
}
function ts_trek_validate_run_mode(bool $apply,bool $confirm,bool $admin,string $origin,$public): bool {$p=parse_url($origin);if(!is_array($p)||strtolower($p['scheme']??'')!=='https'||strtolower($p['host']??'')!=='test.tanzaniasensational.com'||(isset($p['port'])&&(int)$p['port']!==443)||isset($p['user'])||isset($p['pass'])||!in_array($p['path']??'', ['', '/'],true)||isset($p['query'])||isset($p['fragment']))throw new RuntimeException('Exact HTTPS staging origin required.');if(!in_array($public,[0,'0',false],true))throw new RuntimeException('Staging must remain private.');if(!$apply&&$confirm)throw new RuntimeException('Confirmation requires apply.');if($apply&&(!$confirm||!$admin))throw new RuntimeException('Apply requires confirmation and administrator.');return true;}
function ts_trek_expected_existing(array $m): array {$o=[];foreach($m['routes'] as $r){$h=ts_trek_hash($r);$o[$r['slug']]=['owner'=>'approved-trekking-import-v1','source_id'=>$r['source_id'],'import_hash'=>$h,'snapshot_hash'=>$h,'actual_snapshot_hash'=>$h,'state'=>'ready'];}return $o;}
function ts_trek_build_plan(array $m,array $existing): array {ts_trek_validate_manifest($m);$out=[];foreach($m['routes'] as $r){$s=$r['slug'];if(!isset($existing[$s])){$out[]=['action'=>'create','kind'=>'route','slug'=>$s];continue;}$e=$existing[$s];if(($e['owner']??'')!=='approved-trekking-import-v1'||($e['source_id']??null)!==$r['source_id']||($e['state']??'')!=='ready'||!hash_equals(ts_trek_hash($r),(string)($e['import_hash']??''))||!hash_equals((string)($e['snapshot_hash']??''),(string)($e['actual_snapshot_hash']??'')))throw new RuntimeException('Refusing collision or editor drift: '.$s);$out[]=['action'=>'unchanged','kind'=>'route','slug'=>$s];}$out[]=['action'=>'create','kind'=>'single_template','slug'=>'ts-single-trek-route'];return $out;}
function ts_trek_verify_backup_directory(string $dir,string $root): array {$d=realpath($dir);$r=realpath($root);if(!$d||!$r||!is_dir($d)||!is_dir($r)||$d===$r||str_starts_with($d.DIRECTORY_SEPARATOR,rtrim($r,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR))throw new RuntimeException('Backup must exist outside document root.');$f=$d.'/SHA256SUMS';if(!is_file($f)||!is_readable($f))throw new RuntimeException('Backup checksum list missing.');$out=[];foreach(file($f,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES) as $line){if(!preg_match('/^([a-f0-9]{64})  ([A-Za-z0-9._-]+)$/i',$line,$m)||isset($out[$m[2]]))throw new RuntimeException('Malformed checksum list.');$p=realpath($d.'/'.$m[2]);if(!$p||dirname($p)!==$d||!is_file($p)||!hash_equals(strtolower($m[1]),strtolower(hash_file('sha256',$p))))throw new RuntimeException('Backup checksum failed.');$out[$m[2]]=$p;}foreach(['database.sql','custom-plugins.tgz','plugin-inventory.txt','theme-inventory.txt'] as $n)if(!isset($out[$n]))throw new RuntimeException('Incomplete backup: '.$n);return $out;}
function ts_trek_runtime_check(): void {foreach(['get_posts','get_post','get_post_meta','update_post_meta','get_field','update_field','acf_get_field','wp_insert_post','wp_update_post','wp_slash','current_user_can','clean_post_cache','home_url','get_option','is_wp_error','wp_json_encode','get_post_status'] as $f)if(!function_exists($f))throw new RuntimeException('Missing dependency: '.$f);if(!defined('ABSPATH')||!defined('ELEMENTOR_VERSION')||!defined('ELEMENTOR_PRO_VERSION')||!class_exists('\\ElementorPro\\Modules\\ThemeBuilder\\Module'))throw new RuntimeException('Elementor Pro is required.');}
function ts_trek_posts(string $type): array{return get_posts(['post_type'=>$type,'post_status'=>['publish','draft','pending','private','future','trash'],'numberposts'=>-1,'suppress_filters'=>true]);}
function ts_trek_state(int $id): array {
    $p = get_post($id);
    if (!is_object($p) || (int)($p->ID ?? 0) !== $id) throw new RuntimeException('Could not read route post: '.$id);
    $fields = [];
    $names = array_keys(ts_trek_expected_fields(['route_family'=>'','duration_variant'=>'','duration'=>0,'difficulty'=>'','hero_image_url'=>'','hero_image_alt'=>'','description'=>'','source_url'=>'','title'=>'']));
    foreach ($names as $name) $fields[$name] = ts_trek_normalize_field($name, get_field($name, $id, false));
    return ['post_type'=>(string)$p->post_type,'post_status'=>(string)$p->post_status,'post_name'=>(string)$p->post_name,'post_title'=>(string)$p->post_title,'post_content'=>(string)$p->post_content,'fields'=>$fields];
}
function ts_trek_collect_plan(array $m): array
{
    $wanted = array_fill_keys(ts_trek_approved_slugs(), true);
    $found = [];
    foreach (ts_trek_posts('ts_trek_route') as $post) {
        if (isset($wanted[$post->post_name])) $found[$post->post_name][] = $post;
    }
    $plan = [];
    foreach ($m['routes'] as $route) {
        $slug = $route['slug'];
        $matches = $found[$slug] ?? [];
        if (!$matches) { $plan[] = ['action'=>'create','kind'=>'route','slug'=>$slug]; continue; }
        if (count($matches) !== 1) throw new RuntimeException('Duplicate staging route slug: '.$slug);
        $post_id = (int)$matches[0]->ID;
        $source_id = (int)get_post_meta($post_id, '_ts_trek_import_source_id', true);
        $source_slug = (string)get_post_meta($post_id, '_ts_trek_import_source_slug', true);
        $state = (string)get_post_meta($post_id, '_ts_trek_import_state', true);
        $snapshot_json = get_post_meta($post_id, '_ts_trek_import_snapshot', true);
        $stored_hash = (string)get_post_meta($post_id, '_ts_trek_import_hash', true);
        if (get_post_meta($post_id, '_ts_trek_import_owner', true) !== 'approved-trekking-import-v1'
            || $source_id !== (int)$route['source_id'] || $source_slug !== $slug || $state !== 'ready'
            || !is_string($snapshot_json) || $stored_hash === '' || !hash_equals($stored_hash, hash('sha256', $snapshot_json))) {
            throw new RuntimeException('Unowned or invalid route collision: '.$slug);
        }
        $saved = json_decode($snapshot_json, true);
        $expected = ts_trek_expected_state($route);
        if (!is_array($saved)) throw new RuntimeException('Invalid route snapshot: '.$slug);
        ts_trek_assert_snapshot_matches_expected($saved, $expected);
        if (!hash_equals(ts_trek_hash($expected), ts_trek_hash(ts_trek_state($post_id)))) {
            throw new RuntimeException('Route content drift; refusing overwrite: '.$slug);
        }
        $plan[] = ['action'=>'unchanged','kind'=>'route','slug'=>$slug,'post_id'=>$post_id];
    }
    return $plan;
}
function ts_trek_template_widget_type(array $data): string
{
    $types = [];
    $visit = static function (array $nodes) use (&$visit, &$types): void {
        foreach ($nodes as $node) {
            if (!is_array($node)) continue;
            if (($node['elType'] ?? null) === 'widget' && is_string($node['widgetType'] ?? null)) $types[] = $node['widgetType'];
            if (is_array($node['elements'] ?? null)) $visit($node['elements']);
        }
    };
    $visit($data);
    return count($types) === 1 ? $types[0] : implode(',', $types);
}

function ts_trek_current_template_state(int $post_id): array
{
    $post = get_post($post_id);
    if (!is_object($post) || (int)($post->ID ?? 0) !== $post_id) throw new RuntimeException('Could not read Elementor template: '.$post_id);
    $data_json = get_post_meta($post_id, '_elementor_data', true);
    $data = is_string($data_json) ? json_decode($data_json, true) : null;
    if (!is_array($data)) throw new RuntimeException('Elementor template data is missing or invalid.');
    $conditions_raw = get_post_meta($post_id, '_elementor_conditions', true);
    if (!is_array($conditions_raw)) throw new RuntimeException('Elementor template conditions are missing or invalid.');
    $conditions = [];
    foreach ($conditions_raw as $condition) {
        if (is_string($condition) && $condition !== '') {
            $conditions[] = $condition;
            continue;
        }
        if (!is_array($condition)) throw new RuntimeException('Elementor template condition is malformed.');
        $normalized = implode('/', array_map('strval', $condition));
        if ($normalized === '') throw new RuntimeException('Elementor template condition is malformed.');
        $conditions[] = $normalized;
    }
    $page_settings = get_post_meta($post_id, '_elementor_page_settings', true);
    return [
        'post_type'=>(string)$post->post_type,'post_status'=>(string)$post->post_status,
        'post_name'=>(string)$post->post_name,'post_title'=>(string)$post->post_title,
        'post_content'=>(string)$post->post_content,
        'template_type'=>(string)get_post_meta($post_id, '_elementor_template_type', true),
        'edit_mode'=>(string)get_post_meta($post_id, '_elementor_edit_mode', true),
        'elementor_version'=>(string)get_post_meta($post_id, '_elementor_version', true),
        'page_settings'=>is_array($page_settings) ? $page_settings : [],
        'elementor_data'=>$data,'widget_type'=>ts_trek_template_widget_type($data),'conditions'=>$conditions,
    ];
}

function ts_trek_plan_template(): array
{
    $matches = array_values(array_filter(ts_trek_posts('elementor_library'), static fn($post): bool => $post->post_name === 'ts-single-trek-route'));
    if (!$matches) return ['action'=>'create','kind'=>'single_template','slug'=>'ts-single-trek-route'];
    if (count($matches) !== 1) throw new RuntimeException('Duplicate trekking template slug.');
    $post_id = (int)$matches[0]->ID;
    $expected = ts_trek_expected_template_state();
    $snapshot_json = get_post_meta($post_id, '_ts_trek_template_snapshot', true);
    $snapshot_hash = (string)get_post_meta($post_id, '_ts_trek_template_hash', true);
    $import_hash = (string)get_post_meta($post_id, '_ts_trek_template_import_hash', true);
    $saved = is_string($snapshot_json) ? json_decode($snapshot_json, true) : null;
    if (get_post_meta($post_id, '_ts_trek_template_owner', true) !== 'approved-trekking-import-v1'
        || get_post_meta($post_id, '_ts_trek_template_state', true) !== 'ready'
        || !is_string($snapshot_json) || !is_array($saved)
        || $snapshot_hash === '' || !hash_equals($snapshot_hash, hash('sha256', $snapshot_json))
        || !hash_equals($import_hash, ts_trek_hash($expected))) {
        throw new RuntimeException('Unowned or invalid trekking template collision.');
    }
    ts_trek_assert_snapshot_matches_expected($saved, $expected);
    if (!hash_equals(ts_trek_hash($expected), ts_trek_hash(ts_trek_current_template_state($post_id)))) {
        throw new RuntimeException('Trekking template content drift; refusing overwrite.');
    }
    return ['action'=>'unchanged','kind'=>'single_template','slug'=>'ts-single-trek-route','post_id'=>$post_id,'expected'=>$expected];
}
function ts_trek_save_meta(int $id,string $key,$value): void
{
    update_post_meta($id, $key, is_string($value) ? wp_slash($value) : $value);
    $actual = get_post_meta($id, $key, true);
    if ($actual !== $value && (!is_scalar($actual) || !is_scalar($value) || (string)$actual !== (string)$value)) {
        throw new RuntimeException('Metadata read-back failed: '.$key);
    }
}
function ts_trek_assert_transactional_storage(): void {global $wpdb;foreach([$wpdb->posts,$wpdb->postmeta,$wpdb->options] as $table){$e=$wpdb->get_var($wpdb->prepare('SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = %s',$table));if(strtoupper((string)$e)!=='INNODB')throw new RuntimeException('Trekking import requires InnoDB tables.');}}
function ts_trek_start_create_transaction(string $slug): void
{
    global $wpdb;
    if ($wpdb->query('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ') === false) throw new RuntimeException('Could not set repeatable-read isolation for route '.$slug);
    if ($wpdb->query('START TRANSACTION') === false) throw new RuntimeException('Could not start route transaction: '.$slug);
}

function ts_trek_lock_slug_for_create(string $post_type, string $slug): void
{
    global $wpdb;
    $query = $wpdb->prepare("SELECT ID FROM {$wpdb->posts} FORCE INDEX (post_name) WHERE post_name = %s AND post_type = %s LIMIT 1 FOR UPDATE", $slug, $post_type);
    $existing_id = $wpdb->get_var($query);
    if ($existing_id === false || (!empty($wpdb->last_error))) throw new RuntimeException('Could not lock route slug: '.$slug);
    if ($existing_id !== null && (int)$existing_id > 0) throw new RuntimeException('A route slug collision appeared after preflight: '.$slug);
}

function ts_trek_quarantine_failed_post(int $post_id, bool $template): bool
{
    if ($post_id < 1) return false;
    clean_post_cache($post_id);
    $post = get_post($post_id);
    if (!is_object($post)) return false;

    $updated = wp_update_post(wp_slash(['ID'=>$post_id,'post_status'=>'draft']), true);
    if (is_wp_error($updated) || (int)$updated !== $post_id) {
        throw new RuntimeException('Could not quarantine failed import post '.$post_id.' as draft.');
    }
    clean_post_cache($post_id);

    if ($template) {
        $manager = ts_trek_conditions_manager();
        if (!is_object($manager) || !method_exists($manager, 'save_conditions')
            || !method_exists($manager, 'clear_location_cache')) {
            throw new RuntimeException('Could not disable targeting for failed Elementor template '.$post_id.'.');
        }
        $manager->save_conditions($post_id, []);
        clean_post_cache($post_id);
        $conditions = get_post_meta($post_id, '_elementor_conditions', true);
        if (!in_array($conditions, [[], '', null, false], true)) {
            throw new RuntimeException('Failed Elementor template still has targeting conditions: '.$post_id.'.');
        }
    }

    $post = get_post($post_id);
    if (!is_object($post) || $post->post_status !== 'draft') {
        throw new RuntimeException('Failed import post is not safely quarantined as draft: '.$post_id.'.');
    }
    return true;
}

function ts_trek_rollback_failed_create(int $post_id, bool $template, string $label): ?string
{
    global $wpdb;
    $notes = [];
    $rollback = $wpdb->query('ROLLBACK');
    if ($rollback === false || !empty($wpdb->last_error)) {
        $notes[] = 'transaction rollback failed';
    }
    try {
        if (ts_trek_quarantine_failed_post($post_id, $template)) {
            $notes[] = 'created '.$label.' remains quarantined as draft; inspect and recover manually';
        }
    } catch (Throwable $recovery_error) {
        $notes[] = 'failed to quarantine '.$label.': '.$recovery_error->getMessage();
    }
    if ($template) {
        try {
            $manager = ts_trek_conditions_manager();
            if (!is_object($manager) || !method_exists($manager, 'clear_location_cache')
                || $manager->clear_location_cache() === false) {
                throw new RuntimeException('Elementor location cache could not be refreshed.');
            }
        } catch (Throwable $cache_error) {
            $notes[] = 'failed to clear Elementor location cache: '.$cache_error->getMessage();
        }
    }
    return $notes ? implode('; ', $notes) : null;
}

function ts_trek_apply_route(array $route): array
{
    global $wpdb;
    ts_trek_start_create_transaction($route['slug']);
    $transaction_active = true;
    $post_id = 0;
    try {
        ts_trek_lock_slug_for_create('ts_trek_route', $route['slug']);
        $post_id = wp_insert_post(wp_slash([
            'post_type'=>'ts_trek_route','post_status'=>'draft','post_name'=>$route['slug'],
            'post_title'=>$route['title'],'post_content'=>'','comment_status'=>'closed','ping_status'=>'closed',
        ]), true);
        if (is_wp_error($post_id) || !is_numeric($post_id) || (int)$post_id < 1) throw new RuntimeException('Could not create route draft: '.$route['slug']);
        $post_id = (int)$post_id;
        foreach (ts_trek_expected_fields($route) as $name => $value) update_field('field_'.$name, $value, $post_id);
        clean_post_cache($post_id);
        $expected_draft = ts_trek_expected_state($route, 'draft');
        if (!hash_equals(ts_trek_hash($expected_draft), ts_trek_hash(ts_trek_state($post_id)))) throw new RuntimeException('Route draft field read-back failed: '.$route['slug']);

        $expected = ts_trek_expected_state($route, 'publish');
        $snapshot_json = wp_json_encode($expected, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
        if (!is_string($snapshot_json)) throw new RuntimeException('Could not encode route ownership snapshot: '.$route['slug']);
        ts_trek_save_meta($post_id, '_ts_trek_import_source_id', (int)$route['source_id']);
        ts_trek_save_meta($post_id, '_ts_trek_import_source_slug', $route['slug']);
        ts_trek_save_meta($post_id, '_ts_trek_import_owner', 'approved-trekking-import-v1');
        ts_trek_save_meta($post_id, '_ts_trek_import_snapshot', $snapshot_json);
        ts_trek_save_meta($post_id, '_ts_trek_import_hash', hash('sha256', $snapshot_json));
        ts_trek_save_meta($post_id, '_ts_trek_import_state', 'publishing');

        $published_id = wp_update_post(wp_slash(['ID'=>$post_id,'post_status'=>'publish']), true);
        if (is_wp_error($published_id) || (int)$published_id !== $post_id) throw new RuntimeException('Could not publish verified route: '.$route['slug']);
        clean_post_cache($post_id);
        if (!hash_equals(ts_trek_hash($expected), ts_trek_hash(ts_trek_state($post_id)))) throw new RuntimeException('Published route read-back failed: '.$route['slug']);
        ts_trek_save_meta($post_id, '_ts_trek_import_state', 'ready');
        if ($wpdb->query('COMMIT') === false) throw new RuntimeException('Route transaction commit failed: '.$route['slug']);
        $transaction_active = false;
        clean_post_cache($post_id);
        return ['action'=>'created','kind'=>'route','slug'=>$route['slug'],'post_id'=>$post_id];
    } catch (Throwable $error) {
        $recovery = $transaction_active ? ts_trek_rollback_failed_create($post_id, false, 'route') : null;
        if ($post_id > 0) clean_post_cache($post_id);
        if ($recovery !== null) {
            throw new RuntimeException($error->getMessage().' Recovery required: '.$recovery.'.', 0, $error);
        }
        throw $error;
    }
}
function ts_trek_conditions_manager()
{
    $module_class = 'ElementorPro\\Modules\\ThemeBuilder\\Module';
    if (!class_exists($module_class) || !method_exists($module_class, 'instance')) throw new RuntimeException('Elementor Pro Theme Builder is unavailable.');
    $module = $module_class::instance();
    return is_object($module) ? $module->get_conditions_manager() : null;
}

function ts_trek_refresh_template_conditions(int $post_id): void
{
    $module_class = 'ElementorPro\\Modules\\ThemeBuilder\\Module';
    $module = class_exists($module_class) ? $module_class::instance() : null;
    $manager = is_object($module) ? $module->get_conditions_manager() : null;
    $post = get_post($post_id);
    if (!is_object($manager) || !method_exists($manager, 'save_conditions') || !method_exists($manager, 'clear_location_cache')
        || !is_object($post) || $post->post_status !== 'publish' || !method_exists($module, 'get_document') || !is_object($module->get_document($post_id))) {
        throw new RuntimeException('Elementor cannot refresh published trekking-template conditions.');
    }
    $manager->save_conditions($post_id, ts_trek_template_conditions_api());
    $manager->clear_location_cache();
    clean_post_cache($post_id);
    if (get_post_meta($post_id, '_elementor_conditions', true) !== ts_trek_expected_template_conditions()) {
        throw new RuntimeException('Published trekking-template conditions failed read-back.');
    }
}

function ts_trek_apply_template(): array
{
    global $wpdb;
    $expected = ts_trek_expected_template_state();
    ts_trek_start_create_transaction('template');
    $transaction_active = true;
    $post_id = 0;
    try {
        ts_trek_lock_slug_for_create('elementor_library', 'ts-single-trek-route');
        $post_id = wp_insert_post(wp_slash([
            'post_type'=>'elementor_library','post_status'=>'draft','post_name'=>'ts-single-trek-route',
            'post_title'=>'TS Single Trekking Route','post_content'=>'','comment_status'=>'closed','ping_status'=>'closed',
        ]), true);
        if (is_wp_error($post_id) || !is_numeric($post_id) || (int)$post_id < 1) throw new RuntimeException('Could not create trekking-template draft.');
        $post_id = (int)$post_id;
        $data_json = wp_json_encode($expected['elementor_data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (!is_string($data_json)) throw new RuntimeException('Could not encode trekking-template Elementor data.');
        ts_trek_save_meta($post_id, '_elementor_template_type', 'single');
        ts_trek_save_meta($post_id, '_elementor_edit_mode', 'builder');
        ts_trek_save_meta($post_id, '_elementor_version', (string)$expected['elementor_version']);
        ts_trek_save_meta($post_id, '_elementor_page_settings', []);
        ts_trek_save_meta($post_id, '_elementor_data', $data_json);
        $manager = ts_trek_conditions_manager();
        if (!is_object($manager) || !method_exists($manager, 'save_conditions')
            || !$manager->save_conditions($post_id, ts_trek_template_conditions_api())) {
            throw new RuntimeException('Could not save trekking-template conditions.');
        }
        $draft = $expected;
        $draft['post_status'] = 'draft';
        clean_post_cache($post_id);
        if (!hash_equals(ts_trek_hash($draft), ts_trek_hash(ts_trek_current_template_state($post_id)))) {
            throw new RuntimeException('Trekking template failed draft-state verification.');
        }
        $snapshot_json = wp_json_encode($expected, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
        if (!is_string($snapshot_json)) throw new RuntimeException('Could not encode trekking-template ownership snapshot.');
        ts_trek_save_meta($post_id, '_ts_trek_template_owner', 'approved-trekking-import-v1');
        ts_trek_save_meta($post_id, '_ts_trek_template_snapshot', $snapshot_json);
        ts_trek_save_meta($post_id, '_ts_trek_template_hash', hash('sha256', $snapshot_json));
        ts_trek_save_meta($post_id, '_ts_trek_template_import_hash', ts_trek_hash($expected));
        ts_trek_save_meta($post_id, '_ts_trek_template_state', 'publishing');
        $published_id = wp_update_post(wp_slash(['ID'=>$post_id,'post_status'=>'publish']), true);
        if (is_wp_error($published_id) || (int)$published_id !== $post_id) throw new RuntimeException('Could not publish verified trekking template.');
        clean_post_cache($post_id);
        if (!hash_equals(ts_trek_hash($expected), ts_trek_hash(ts_trek_current_template_state($post_id)))) {
            wp_update_post(wp_slash(['ID'=>$post_id,'post_status'=>'draft']), true);
            throw new RuntimeException('Trekking template failed post-publish verification.');
        }
        ts_trek_refresh_template_conditions($post_id);
        ts_trek_save_meta($post_id, '_ts_trek_template_state', 'ready');
        if ($wpdb->query('COMMIT') === false) throw new RuntimeException('Trekking template transaction commit failed.');
        $transaction_active = false;
        clean_post_cache($post_id);
        return ['action'=>'created','kind'=>'single_template','slug'=>'ts-single-trek-route','post_id'=>$post_id];
    } catch (Throwable $error) {
        $recovery = $transaction_active ? ts_trek_rollback_failed_create($post_id, true, 'template') : null;
        if ($post_id > 0) clean_post_cache($post_id);
        if ($recovery !== null) {
            throw new RuntimeException($error->getMessage().' Recovery required: '.$recovery.'.', 0, $error);
        }
        throw $error;
    }
}
function ts_trek_import_run(bool $apply=false,bool $confirm=false,string $backup=''): array
{
    if (!defined('ABSPATH') || !function_exists('home_url')) throw new RuntimeException('Must run in WordPress.');
    ts_trek_runtime_check();
    $origin = (string)home_url('/');
    $admin = current_user_can('manage_options');
    $public = get_option('blog_public');
    ts_trek_validate_run_mode($apply, $confirm, $admin, $origin, $public);
    $manifest = json_decode((string)file_get_contents(__DIR__.'/trekking-import-manifest.json'), true, 512, JSON_THROW_ON_ERROR);
    ts_trek_validate_manifest($manifest);
    ts_trek_validate_acf_schema(static fn(string $key) => acf_get_field($key));

    if ($apply) {
        if ($backup === '') throw new RuntimeException('Apply requires backup directory.');
        ts_trek_verify_backup_directory($backup, ABSPATH);
        ts_trek_assert_transactional_storage();
    }

    $route_plan = ts_trek_collect_plan($manifest);
    $template_plan = ts_trek_plan_template();
    $report = ['site_origin'=>$origin,'blog_public'=>$public,'routes'=>$route_plan,'template'=>$template_plan];
    if (!$apply) return $report;

    $missing_routes = array_filter($route_plan, static fn(array $item): bool => $item['action'] === 'create');
    if ($template_plan['action'] === 'unchanged' && $missing_routes) {
        throw new RuntimeException('An owned trekking template exists while an approved route is missing; refusing partial recovery.');
    }

    $applied_routes = [];
    foreach ($manifest['routes'] as $index => $route) {
        $item = $route_plan[$index];
        $applied_routes[] = $item['action'] === 'create'
            ? ts_trek_apply_route($route)
            : ['action'=>'unchanged','kind'=>'route','slug'=>$route['slug'],'post_id'=>(int)$item['post_id']];
    }

    if ($template_plan['action'] === 'create') {
        $applied_template = ts_trek_apply_template();
    } else {
        $template_id = (int)$template_plan['post_id'];
        ts_trek_refresh_template_conditions($template_id);
        $applied_template = ['action'=>'unchanged','kind'=>'single_template','slug'=>'ts-single-trek-route','post_id'=>$template_id];
    }

    if (count(array_filter($applied_routes, static fn(array $item): bool => $item['action'] === 'created')) > 0) {
        flush_rewrite_rules(false);
    }
    $verified_routes = ts_trek_collect_plan($manifest);
    foreach ($verified_routes as $item) {
        if ($item['action'] !== 'unchanged') throw new RuntimeException('Post-apply route verification failed: '.$item['slug']);
    }
    $verified_template = ts_trek_plan_template();
    if ($verified_template['action'] !== 'unchanged') throw new RuntimeException('Post-apply trekking template verification failed.');
    return [
        'applied'=>['routes'=>$applied_routes,'template'=>$applied_template],
        'verification'=>['routes'=>$verified_routes,'template'=>$verified_template],
    ];
}
