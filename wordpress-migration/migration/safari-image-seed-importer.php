<?php
/** Staging-only image media seeding for the safari landing and tour archive. */
if (!defined('ABSPATH')) { exit; }

function ts_safari_image_seed_asset_map(array $manifest): array {
    $map=[];
    foreach($manifest['assets']??[] as $asset){
        $key=$asset['key']??null;
        if(!is_string($key)||$key===''||isset($map[$key]))throw new RuntimeException('Safari image seed contains a missing or duplicate asset key.');
        $map[$key]=$asset;
    }
    return $map;
}

function ts_safari_image_seed_normalize_landing_content(string $content,array $landing,array $manifest,array $local_urls): string {
    $escape=static fn($value)=>htmlspecialchars((string)$value,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');
    $assets=ts_safari_image_seed_asset_map($manifest);
    foreach($local_urls as $key=>$url){$asset=$assets[$key]??null;if(!is_array($asset)||!is_string($url)||$url==='')continue;$content=str_replace($escape($url),$escape($asset['source_url']),$content);}
    return $content;
}

function ts_safari_image_seed_snapshot(array $page,array $destinations=[]): array {
    if((int)($page['ID']??0)!==27||($page['post_type']??'')!=='page'||($page['post_status']??'')!=='publish'||($page['post_name']??'')!=='safaris')throw new RuntimeException('Safari image-seed snapshot target is not the approved published landing page.');
    $post=$page;unset($post['meta']);ksort($post);$meta=$page['meta']??[];ksort($meta);
    $snapshot=['post'=>$post,'meta'=>$meta,'meta_rows'=>ts_safari_landing_raw_meta_rows(27)];if($destinations)$snapshot['destinations']=$destinations;
    $json=wp_json_encode($snapshot,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);
    if(!is_string($json))throw new RuntimeException('Could not encode the full safari image-seed page snapshot.');
    return ['json'=>$json,'hash'=>hash('sha256',$json)];
}

function ts_safari_image_seed_verify_backup(int $backupId,string $backupHash,array $manifest): array {
    ts_safari_verify_landing_backup($backupId,$backupHash);$json=get_post_meta($backupId,'_ts_safari_landing_backup_snapshot',true);$snapshot=json_decode((string)$json,true,512,JSON_THROW_ON_ERROR);$destinations=$snapshot['destinations']??null;
    if(!is_array($destinations)||count($destinations)!==count($manifest['landing']['destinations']))throw new RuntimeException('Safari image-seed backup does not contain the exact destination rollback snapshot.');
    foreach($manifest['landing']['destinations'] as $target){$id=(int)$target['post_id'];$state=$destinations[$id]??$destinations[(string)$id]??null;if(!is_array($state)||!is_array($state['post']??null)||!is_array($state['meta_rows']??null)||!is_array($state['acf_fields']??null)||(int)($state['post']['ID']??0)!==$id||($state['post']['post_type']??'')!=='ts_destination'||($state['post']['post_name']??'')!==$target['slug']||!array_key_exists('image',$state['acf_fields'])||!array_key_exists('image_url',$state['acf_fields']))throw new RuntimeException('Safari image-seed destination rollback snapshot is invalid: '.$target['slug']);}
    return $snapshot;
}

function ts_safari_image_seed_with_writer_lock(array $manifest,callable $operation) {
    global $wpdb;
    if(!isset($wpdb)||!method_exists($wpdb,'get_var')||!method_exists($wpdb,'prepare'))throw new RuntimeException('Safari image seed cannot acquire its database writer lock.');
    $blogId=function_exists('get_current_blog_id')?(int)get_current_blog_id():1;$lockName=substr('ts_safari_image_seed_'.hash('sha256',$blogId.'|'.($manifest['owner']??'').'|'.(int)($manifest['page_id']??0)),0,64);
    $acquired=$wpdb->get_var($wpdb->prepare('SELECT GET_LOCK(%s, %d)',$lockName,30));if((int)$acquired!==1)throw new RuntimeException('Another safari image-seed writer is active or the database advisory lock failed.');
    $result=null;$operationError=null;try{$result=$operation();}catch(Throwable $e){$operationError=$e;}
    try{$released=$wpdb->get_var($wpdb->prepare('SELECT RELEASE_LOCK(%s)',$lockName));}catch(Throwable $e){$released=null;if($operationError===null)$operationError=$e;}
    if($operationError!==null){if((int)$released!==1)throw new RuntimeException($operationError->getMessage().' (safari image-seed writer lock release is unverified)',0,$operationError);throw $operationError;}
    if((int)$released!==1)throw new RuntimeException('Safari image-seed writer lock release could not be verified.');
    return $result;
}

function ts_safari_image_seed_lock_target(int $id,string $type,string $slug,string $status='publish'): object {
    global $wpdb;
    if($id<1||!isset($wpdb->posts,$wpdb->postmeta)||!method_exists($wpdb,'get_row')||!method_exists($wpdb,'get_results')||!method_exists($wpdb,'prepare'))throw new RuntimeException('Safari image-seed target cannot be locked safely.');
    $row=$wpdb->get_row($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE ID=%d FOR UPDATE",$id));
    $lockedId=is_object($row)?(int)($row->ID??0):(is_array($row)?(int)($row['ID']??0):0);
    if($lockedId!==$id)throw new RuntimeException('Safari image-seed post row lock failed: '.$slug);
    $wpdb->last_error='';$rows=$wpdb->get_results($wpdb->prepare("SELECT meta_id FROM {$wpdb->postmeta} WHERE post_id=%d ORDER BY meta_id FOR UPDATE",$id));
    if(!is_array($rows)||!empty($wpdb->last_error))throw new RuntimeException('Safari image-seed postmeta range lock failed: '.$slug);
    clean_post_cache($id);$post=get_post($id);
    if(!$post||($post->post_type??'')!==$type||($post->post_status??'')!==$status||($post->post_name??'')!==$slug)throw new RuntimeException('Safari image-seed target identity changed while acquiring its lock: '.$slug);
    return $post;
}

function ts_safari_image_seed_require_owned_landing(array $landing): array {
    $page=ts_safari_read_landing_page(27);$owner=get_post_meta(27,'_ts_safari_landing_owner',true);$backup=(int)get_post_meta(27,'_ts_safari_landing_backup_id',true);$backupHash=get_post_meta(27,'_ts_safari_landing_snapshot_hash',true);$managedHash=get_post_meta(27,'_ts_safari_landing_managed_hash',true);
    if(!$page||($page['post_type']??'')!=='page'||($page['post_status']??'')!=='publish'||($page['post_name']??'')!=='safaris'||$owner!=='approved-safari-landing-import-v1'||$backup<1||!is_string($backupHash)||!preg_match('/^[a-f0-9]{64}$/',$backupHash)||!is_string($managedHash)||!preg_match('/^[a-f0-9]{64}$/',$managedHash)||!hash_equals($managedHash,ts_safari_landing_managed_hash($page)))throw new RuntimeException('Safari image seed requires the owned source landing and an intact managed-state hash.');
    ts_safari_verify_landing_backup($backup,$backupHash);
    $route=ts_safari_landing_plan($landing);
    if(($route['action']??'')!=='unchanged'||(int)($route['page_id']??0)!==27)throw new RuntimeException('Safari image seed requires the exact source-backed landing route and original private clone.');
    return ['page'=>$page,'owner'=>$owner,'backup_id'=>$backup,'backup_hash'=>$backupHash,'managed_hash'=>$managedHash];
}

function ts_safari_validate_image_seed_manifest(array $manifest,array $landing): void {
    if(($manifest['version']??null)!==1||($manifest['owner']??'')!=='approved-safari-image-seed-v1'||(int)($manifest['page_id']??0)!==27)throw new RuntimeException('Safari image seed manifest identity mismatch.');
    ts_safari_validate_landing_manifest($landing);
    $assets=ts_safari_image_seed_asset_map($manifest);
    $expectedKeys=['landing.hero','landing.difference','destination.serengeti','destination.ngorongoro','destination.tarangire','destination.kilimanjaro','destination.lake-manyara','destination.zanzibar','destination.ruaha','destination.nyerere','destination.mahale'];
    if(array_keys($assets)!==$expectedKeys||count($manifest['assets']??[])!==count($expectedKeys))throw new RuntimeException('Safari image seed manifest must contain the exact eleven live-page assets.');
    $expectedUrls=['landing.hero'=>$landing['hero_image'],'landing.difference'=>$landing['difference_image']];
    $expectedAlts=['landing.hero'=>'African safari wilderness — lioness on the Serengeti plains at golden hour','landing.difference'=>'Tanzania safari experience — guide and traveler observing wildlife on the savanna'];
    foreach($landing['destinations'] as $card){$key='destination.'.$card['slug'];$expectedUrls[$key]=$card['image'];$expectedAlts[$key]=$card['alt'];}

    foreach($expectedUrls as $key=>$url){$asset=$assets[$key]??null;if(!is_array($asset)||($asset['source_url']??null)!==$url||($asset['alt']??null)!==($expectedAlts[$key]??null)||!is_string($asset['title']??null)||trim($asset['title'])==='')throw new RuntimeException('Safari image seed source or exact live alt metadata mismatch: '.$key);$parsed=wp_parse_url($url);if(!is_array($parsed)||($parsed['scheme']??'')!=='https'||isset($parsed['user'])||isset($parsed['pass'])||isset($parsed['fragment']))throw new RuntimeException('Safari image seed URL is malformed: '.$key);}
    $destinationIds=['serengeti'=>15,'ngorongoro'=>16,'tarangire'=>17,'kilimanjaro'=>51,'lake-manyara'=>53,'zanzibar'=>61,'ruaha'=>59,'nyerere'=>57,'mahale'=>55];
    if(array_column($manifest['landing']['destinations']??[],'slug')!==array_keys($destinationIds))throw new RuntimeException('Safari image seed destination order mismatch.');
    foreach($destinationIds as $slug=>$id){$row=$manifest['landing']['destinations'][array_search($slug,array_column($manifest['landing']['destinations'],'slug'),true)]??[];if((int)($row['post_id']??0)!==$id||($row['asset_key']??'')!=='destination.'.$slug)throw new RuntimeException('Safari image seed destination ID/slug/asset mismatch: '.$slug);}
    if(($manifest['landing']['hero_asset']??'')!=='landing.hero'||($manifest['landing']['difference_asset']??'')!=='landing.difference')throw new RuntimeException('Safari image seed landing hero mapping mismatch.');
    if(($manifest['legacy_tours']??null)!==[])throw new RuntimeException('Legacy tours without exact live-source images must remain untouched.');
}


function ts_safari_image_seed_verify_attachment(int $id,array $asset,string $owner): array {
    $post=get_post($id);$savedOwner=get_post_meta($id,'_ts_safari_seed_owner',true);$key=get_post_meta($id,'_ts_safari_seed_key',true);$source=get_post_meta($id,'_ts_safari_seed_source',true);$hash=get_post_meta($id,'_ts_safari_seed_hash',true);$alt=get_post_meta($id,'_wp_attachment_image_alt',true);
    if(!$post||($post->post_type??'')!=='attachment'||($post->post_status??'')!=='inherit'||$savedOwner!==$owner||$key!==$asset['key']||$source!==$asset['source_url']||$alt!==$asset['alt']||!is_string($hash)||!preg_match('/^[a-f0-9]{64}$/',$hash))throw new RuntimeException('Safari seeded image attachment ownership/state mismatch: '.$asset['key']);
    $file=ts_safari_hero_file_path($id);$actual=hash_file('sha256',$file);if(!is_string($actual)||!hash_equals($hash,$actual))throw new RuntimeException('Safari seeded image content drift: '.$asset['key']);
    $url=wp_get_attachment_url($id);if(!is_string($url)||!str_starts_with($url,'https://test.tanzaniasensational.com/'))throw new RuntimeException('Safari seeded image does not resolve to the staging media origin: '.$asset['key']);
    return ['id'=>$id,'url'=>$url,'file'=>$file,'sha256'=>$hash,'created'=>false];
}

function ts_safari_image_seed_find_attachment(array $asset,string $owner): ?array {
    $rows=get_posts(['post_type'=>'attachment','post_status'=>['inherit','private','publish','draft','pending','future','trash'],'numberposts'=>-1,'meta_key'=>'_ts_safari_seed_key','meta_value'=>$asset['key'],'suppress_filters'=>true]);
    if(!is_array($rows))throw new RuntimeException('Could not inspect seeded safari image attachments.');
    if(count($rows)>1)throw new RuntimeException('Duplicate seeded safari image keys are ambiguous: '.$asset['key']);
    if(!$rows)return null;
    return ts_safari_image_seed_verify_attachment((int)$rows[0]->ID,$asset,$owner);
}

function ts_safari_image_seed_sideload_asset(array $asset): array {
    $path=__DIR__.'/safari-image-seed-manifest.json';$manifest=json_decode((string)file_get_contents($path),true,512,JSON_THROW_ON_ERROR);$landing=json_decode((string)file_get_contents(__DIR__.'/safari-landing-manifest.json'),true,512,JSON_THROW_ON_ERROR);ts_safari_validate_image_seed_manifest($manifest,$landing);$approved=ts_safari_image_seed_asset_map($manifest)[$asset['key']??'']??null;
    if(!is_array($approved)||$approved!==$asset)throw new RuntimeException('Safari image URL or metadata is not an exact manifest asset.');
    $owner=$manifest['owner'];$existing=ts_safari_image_seed_find_attachment($asset,$owner);if($existing!==null)return $existing;
    $u=wp_parse_url($asset['source_url']);$host=$u['host']??'';$pathPart=$u['path']??'';
    $validDomain=($host==='images.unsplash.com'&&preg_match('~^/photo-[A-Za-z0-9-]+$~',$pathPart))||($host==='tanzaniasensational.com'&&preg_match('~^/storage/destinations/[A-Za-z0-9-]+\.jpg$~',$pathPart));
    if(($u['scheme']??'')!=='https'||!$validDomain||isset($u['port'])||isset($u['user'])||isset($u['pass'])||isset($u['fragment']))throw new RuntimeException('Safari image source is outside the exact HTTPS asset allowlist: '.$asset['key']);
    if(!function_exists('wp_safe_remote_get'))throw new RuntimeException('WordPress safe HTTP client is unavailable for safari image seeding.');
    $response=wp_safe_remote_get($asset['source_url'],['redirection'=>0,'timeout'=>20,'limit_response_size'=>8000001,'headers'=>['Accept'=>'image/jpeg']]);
    if(is_wp_error($response)||wp_remote_retrieve_response_code($response)!==200)throw new RuntimeException('Safari image HTTP request failed or attempted a redirect: '.$asset['key']);
    $contentType=strtolower(trim(explode(';',(string)wp_remote_retrieve_header($response,'content-type'))[0]));$body=wp_remote_retrieve_body($response);
    if($contentType!=='image/jpeg'||!is_string($body)||strlen($body)<4||strlen($body)>8000000)throw new RuntimeException('Safari image response has invalid content type or size: '.$asset['key']);
    $image=function_exists('getimagesizefromstring')?@getimagesizefromstring($body):false;
    if(!is_array($image)||($image[2]??null)!==IMAGETYPE_JPEG||($image[0]??0)<1||($image[1]??0)<1||($image[0]*$image[1])>40000000)throw new RuntimeException('Safari image response is not a bounded JPEG: '.$asset['key']);
    if(!function_exists('wp_handle_sideload'))require_once ABSPATH.'wp-admin/includes/file.php';if(!function_exists('wp_generate_attachment_metadata'))require_once ABSPATH.'wp-admin/includes/image.php';
    if(!function_exists('wp_handle_sideload')||!function_exists('wp_generate_attachment_metadata')||!function_exists('wp_update_attachment_metadata'))throw new RuntimeException('WordPress media upload APIs are unavailable for safari image seeding.');
    $uploadName=sanitize_file_name(str_replace('.','-',$asset['key']).'.jpg');$hash=hash('sha256',$body);$tmp=wp_tempnam($uploadName);if(!is_string($tmp)||$tmp===''||file_put_contents($tmp,$body,LOCK_EX)!==strlen($body)){if(is_string($tmp)&&is_file($tmp))@unlink($tmp);throw new RuntimeException('Could not stage validated safari image bytes.');}
    $sideload_file=['name'=>$uploadName,'tmp_name'=>$tmp,'type'=>'image/jpeg','error'=>0,'size'=>strlen($body)];try{$handled=wp_handle_sideload($sideload_file,['test_form'=>false,'mimes'=>['jpg|jpeg'=>'image/jpeg']]);}catch(Throwable $e){if(is_file($tmp))@unlink($tmp);throw $e;}
    if(!is_array($handled)||!empty($handled['error'])||empty($handled['file'])||($handled['type']??'')!=='image/jpeg'){if(is_file($tmp))@unlink($tmp);if(is_array($handled)&&is_string($handled['file']??null))ts_safari_unlink_upload_file($handled['file']);throw new RuntimeException('WordPress rejected safari image sideload: '.$asset['key']);}
    $file=realpath($handled['file']);$base=ts_safari_hero_upload_base();if(!is_string($file)||!str_starts_with($file,$base.DIRECTORY_SEPARATOR)||!hash_equals($hash,(string)hash_file('sha256',$file))){if(is_string($file)&&is_file($file))@unlink($file);throw new RuntimeException('Safari image sideload path/content verification failed: '.$asset['key']);}
    $id=wp_insert_attachment(['post_mime_type'=>'image/jpeg','post_title'=>sanitize_text_field($asset['title']),'post_status'=>'inherit','post_parent'=>0],$file,0,true);if(is_wp_error($id)||!is_numeric($id)||(int)$id<1){if(is_file($file))@unlink($file);throw new RuntimeException('Could not create safari image attachment: '.$asset['key']);}$id=(int)$id;$metadata=[];
    try{
        foreach(['_ts_safari_seed_owner'=>$owner,'_ts_safari_seed_key'=>$asset['key'],'_ts_safari_seed_source'=>$asset['source_url'],'_ts_safari_seed_hash'=>$hash] as $key=>$value)if(!add_post_meta($id,$key,$value,true))throw new RuntimeException('Could not save safari image ownership metadata: '.$asset['key']);
        update_post_meta($id,'_wp_attachment_image_alt',$asset['alt']);if(get_post_meta($id,'_wp_attachment_image_alt',true)!==$asset['alt'])throw new RuntimeException('Safari image alt text failed read-back: '.$asset['key']);
        $metadata=wp_generate_attachment_metadata($id,$file);if(!is_array($metadata)||($metadata['width']??0)!==$image[0]||($metadata['height']??0)!==$image[1])throw new RuntimeException('Safari image metadata generation failed: '.$asset['key']);
        wp_update_attachment_metadata($id,$metadata);$saved=function_exists('wp_get_attachment_metadata')?wp_get_attachment_metadata($id):false;if(!is_array($saved)||($saved['file']??null)!==($metadata['file']??null)||($saved['width']??0)!==$image[0]||($saved['height']??0)!==$image[1])throw new RuntimeException('Safari image metadata persistence failed: '.$asset['key']);
        foreach($metadata['sizes']??[] as $size){$sizeFile=$size['file']??null;if(!is_string($sizeFile)||!is_file(dirname($file).DIRECTORY_SEPARATOR.basename($sizeFile)))throw new RuntimeException('Safari generated image size is missing: '.$asset['key']);}
        $verified=ts_safari_image_seed_verify_attachment($id,$asset,$owner);$verified['created']=true;return $verified;
    }catch(Throwable $e){try{ts_safari_cleanup_new_hero_attachment($id,$file,is_array($metadata)?$metadata:[]);}catch(Throwable $cleanup){throw new RuntimeException($e->getMessage().' (image cleanup is unverified; manual recovery required)',0,$cleanup);}throw $e;}
}

function ts_safari_image_seed_plan(array $manifest,array $landing,string $snapshot_hash=''): array {
    ts_safari_validate_image_seed_manifest($manifest,$landing);
    $livePage=ts_safari_read_landing_page((int)$manifest['page_id']);$liveHash=ts_safari_landing_managed_hash($livePage);$storedHash=$livePage['meta']['_ts_safari_landing_managed_hash'][0]??'';
    if(!is_string($storedHash)||!preg_match('/^[a-f0-9]{64}$/',$storedHash)||!hash_equals($storedHash,$liveHash))throw new RuntimeException('Safari landing managed-state ownership hash is missing or stale.');
    if($snapshot_hash!==''&&(!preg_match('/^[a-f0-9]{64}$/',$snapshot_hash)||!hash_equals($liveHash,$snapshot_hash)))throw new RuntimeException('Safari image seed received a stale landing managed-state SHA-256.');
    $snapshot_hash=$liveHash;
    $owner=$manifest['owner'];$assets=[];$assetIds=[];$assetUrls=[];$changed=false;
    foreach($manifest['assets'] as $asset){$found=ts_safari_image_seed_find_attachment($asset,$owner);if($found===null){$assets[$asset['key']]=['action'=>'create','source_url'=>$asset['source_url']];$changed=true;}else{$assets[$asset['key']]=['action'=>'unchanged','attachment_id'=>$found['id'],'source_url'=>$asset['source_url'],'sha256'=>$found['sha256']];$assetIds[$asset['key']]=$found['id'];$assetUrls[$asset['key']]=$found['url'];}}
    $destinations=[];
    foreach($manifest['landing']['destinations'] as $target){$post=get_post((int)$target['post_id']);if(!$post||($post->post_type??'')!=='ts_destination'||($post->post_status??'')!=='publish'||($post->post_name??'')!==$target['slug'])throw new RuntimeException('Safari destination image target identity changed: '.$target['slug']);$current=ts_safari_normalize_field_value('image',get_field('ts_dest_hero_image',(int)$target['post_id'],false));$url=get_field('ts_dest_hero_image_url',(int)$target['post_id'],false);$asset=ts_safari_image_seed_asset_map($manifest)[$target['asset_key']];$imageOwner=get_post_meta((int)$target['post_id'],'_ts_safari_content_image_owner',true);$attachment=(int)($assetIds[$target['asset_key']]??0);
        if($current!==[]){if($attachment<1||$current!==$attachment||$imageOwner!==$owner||(string)get_post_meta((int)$target['post_id'],'_ts_safari_content_image_key',true)!==$target['asset_key']||($url!==null&&$url!==''&&$url!==false))throw new RuntimeException('Unowned or mismatched destination hero image collision: '.$target['slug']);$action='unchanged';}
        else{if($imageOwner!==''||($url!==null&&$url!==''&&$url!==false&&$url!==$asset['source_url']))throw new RuntimeException('Destination image source field drifted; refusing overwrite: '.$target['slug']);$action='seed';$changed=true;}
        $destinations[]=['action'=>$action,'post_id'=>(int)$target['post_id'],'slug'=>$target['slug'],'asset_key'=>$target['asset_key'],'clear_source_url'=>($url!==null&&$url!==''&&$url!==false)];
    }
    $legacy=[];
    foreach($manifest['legacy_tours'] as $target){$post=get_post((int)$target['post_id']);if(!$post||($post->post_type??'')!=='ts_tour'||($post->post_status??'')!=='publish'||($post->post_name??'')!==$target['slug'])throw new RuntimeException('Safari legacy tour image target identity changed: '.$target['slug']);$current=ts_safari_normalize_field_value('image',get_field('ts_tour_hero_image',(int)$target['post_id'],false));$assetKey=$target['asset_key'];$asset=ts_safari_image_seed_asset_map($manifest)[$assetKey];$attachment=(int)($assetIds[$assetKey]??0);$imageOwner=get_post_meta((int)$target['post_id'],'_ts_safari_content_image_owner',true);
        if($current!==[]){if($attachment<1||$current!==$attachment||$imageOwner!==$owner||(string)get_post_meta((int)$target['post_id'],'_ts_safari_content_image_key',true)!==$assetKey)throw new RuntimeException('Unowned or mismatched legacy tour hero image collision: '.$target['slug']);$action='unchanged';}
        else{if($imageOwner!=='')throw new RuntimeException('Legacy tour image ownership drifted; refusing overwrite: '.$target['slug']);$action='seed';$changed=true;}
        $legacy[]=['action'=>$action,'post_id'=>(int)$target['post_id'],'slug'=>$target['slug'],'asset_key'=>$assetKey];
    }
    $landingPage=get_post((int)$manifest['page_id']);if(!$landingPage||($landingPage->post_type??'')!=='page'||($landingPage->post_status??'')!=='publish'||($landingPage->post_name??'')!=='safaris')throw new RuntimeException('Safari image seed landing page identity changed.');
    $resolved=ts_safari_resolve_destination_cards($landing,static fn($slug)=>get_posts(['post_type'=>'ts_destination','post_status'=>'publish','name'=>$slug,'numberposts'=>2,'suppress_filters'=>true]));$sourceHtml=ts_safari_render_landing($landing,$resolved);$currentContent=(string)($landingPage->post_content??'');
    if(ts_safari_image_seed_normalize_landing_content($currentContent,$landing,$manifest,$assetUrls)!==$sourceHtml)throw new RuntimeException('Safari landing image markup/copy drifted; refusing to overwrite editor content.');
    $landingKeys=['landing.hero','landing.difference'];foreach($manifest['landing']['destinations'] as $target)$landingKeys[]=$target['asset_key'];$allLandingLocal=count(array_diff($landingKeys,array_keys($assetUrls)))===0;$expectedLocalHtml=ts_safari_render_landing($landing,$resolved,$assetUrls);$landingPageAction=$allLandingLocal&&$currentContent===$expectedLocalHtml?'unchanged':'seed';if($landingPageAction==='seed')$changed=true;
    $seedOwner=get_post_meta((int)$manifest['page_id'],'_ts_safari_image_seed_owner',true);$seedBackupId=(int)get_post_meta((int)$manifest['page_id'],'_ts_safari_image_seed_backup_id',true);$seedBackupHash=get_post_meta((int)$manifest['page_id'],'_ts_safari_image_seed_backup_hash',true);$hasSeedMarkers=$seedOwner!==''||$seedBackupId>0||$seedBackupHash!=='';
    if($hasSeedMarkers){if($seedOwner!==$owner||$seedBackupId<1||!is_string($seedBackupHash)||!preg_match('/^[a-f0-9]{64}$/',$seedBackupHash))throw new RuntimeException('Safari image-seed page ownership markers are incomplete or unowned.');ts_safari_image_seed_verify_backup($seedBackupId,$seedBackupHash,$manifest);}
    elseif($landingPageAction==='unchanged')throw new RuntimeException('Landing already uses local media without a verified image-seed preservation clone.');
    return ['action'=>$changed?'seed':'unchanged','snapshot_hash'=>$snapshot_hash,'managed_hash'=>$snapshot_hash,'assets'=>$assets,'destinations'=>$destinations,'legacy_tours'=>$legacy,'landing_page'=>['action'=>$landingPageAction,'page_id'=>(int)$manifest['page_id'],'image_count'=>count($landingKeys)]];
}

function ts_safari_image_seed_apply(array $manifest,array $landing,string $snapshot_hash): array {
    if(!preg_match('/^[a-f0-9]{64}$/',$snapshot_hash))throw new RuntimeException('Safari image seed apply requires the exact managed-state hash from dry-run.');
    return ts_safari_image_seed_with_writer_lock($manifest,static fn()=>ts_safari_image_seed_apply_locked($manifest,$landing,$snapshot_hash));
}

function ts_safari_image_seed_apply_locked(array $manifest,array $landing,string $snapshot_hash): array {
    global $wpdb;
    $plan=ts_safari_image_seed_plan($manifest,$landing,$snapshot_hash);
    if($plan['action']==='unchanged'){ts_safari_image_seed_require_owned_landing($landing);return $plan;}
    $preflight=ts_safari_image_seed_require_owned_landing($landing);
    if(!hash_equals($snapshot_hash,$preflight['managed_hash']))throw new RuntimeException('Safari landing changed after image-seed dry-run; refusing apply.');
    foreach(['get_field','get_field_object','update_field'] as $function)if(!function_exists($function))throw new RuntimeException('Safari image seed requires active ACF API: '.$function);
    ts_safari_require_transactional_tables();

    $assets=ts_safari_image_seed_asset_map($manifest);$attachments=[];$localUrls=[];
    // Media files are outside the database transaction. Keep exact-owned assets for a safe resume.
    foreach($manifest['assets'] as $asset){$row=ts_safari_image_seed_sideload_asset($asset);$attachments[$asset['key']]=$row;$localUrls[$asset['key']]=$row['url'];}

    $destinationTargets=$manifest['landing']['destinations'];
    $readTargetState=static function(int $id): array {
        $post=get_post($id);if(!$post)throw new RuntimeException('Safari image-seed target disappeared during read-back: '.$id);
        return ['post'=>(array)$post,'meta_rows'=>ts_safari_landing_raw_meta_rows($id),'acf_fields'=>['image'=>get_field('ts_dest_hero_image',$id,false),'image_url'=>get_field('ts_dest_hero_image_url',$id,false)]];
    };
    $stateHash=static function(array $state): string {$json=wp_json_encode($state,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);if(!is_string($json))throw new RuntimeException('Could not encode safari image-seed recovery state.');return hash('sha256',$json);};
    $destinationBefore=[];foreach($destinationTargets as $target){$id=(int)$target['post_id'];$destinationBefore[$id]=$readTargetState($id);}
    $pageBefore=ts_safari_read_landing_page(27);
    if(!hash_equals($snapshot_hash,ts_safari_landing_managed_hash($pageBefore)))throw new RuntimeException('Safari landing drifted during media preparation; no page or destination fields were changed.');
    $pageSnapshot=ts_safari_image_seed_snapshot($pageBefore);$seedSnapshot=ts_safari_image_seed_snapshot($pageBefore,$destinationBefore);$seedBackupId=0;

    $lockTargets=[['id'=>27,'type'=>'page','slug'=>'safaris']];
    foreach($destinationTargets as $target)$lockTargets[]=['id'=>(int)$target['post_id'],'type'=>'ts_destination','slug'=>$target['slug']];
    foreach($attachments as $key=>$attachment){$post=get_post((int)$attachment['id']);if(!$post||($post->post_type??'')!=='attachment'||($post->post_status??'')!=='inherit')throw new RuntimeException('Safari image attachment changed before its row lock: '.$key);$lockTargets[]=['id'=>(int)$attachment['id'],'type'=>'attachment','slug'=>(string)$post->post_name,'status'=>'inherit','asset_key'=>$key];}
    usort($lockTargets,static fn($a,$b)=>$a['id']<=>$b['id']);
    $pageWriteStarted=false;$transactionActive=false;
    if($wpdb->query('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ')===false)throw new RuntimeException('Could not set safari image-seed transaction isolation.');
    if($wpdb->query('START TRANSACTION')===false){$rollback=$wpdb->query('ROLLBACK');if($rollback===false)throw new RuntimeException('Safari image-seed transaction start failed and rollback could not be verified.');throw new RuntimeException('Could not start safari image-seed transaction.');}
    $transactionActive=true;
    try {
        foreach($lockTargets as $target){ts_safari_image_seed_lock_target((int)$target['id'],$target['type'],$target['slug'],$target['status']??'publish');if($target['type']==='attachment'){$key=$target['asset_key'];$verified=ts_safari_image_seed_find_attachment($assets[$key],$manifest['owner']);if(!$verified||(int)$verified['id']!==(int)$target['id']||!hash_equals((string)$verified['sha256'],(string)$attachments[$key]['sha256']))throw new RuntimeException('Safari media ownership/content changed under lock: '.$key);}}
        $lockedPage=ts_safari_read_landing_page(27);$lockedSnapshot=ts_safari_image_seed_snapshot($lockedPage);
        if(!hash_equals($snapshot_hash,ts_safari_landing_managed_hash($lockedPage))||!hash_equals($pageSnapshot['hash'],$lockedSnapshot['hash']))throw new RuntimeException('Safari landing managed state changed while image seed waited for locks.');
        foreach($destinationTargets as $target){$id=(int)$target['post_id'];if(!hash_equals($stateHash($destinationBefore[$id]),$stateHash($readTargetState($id))))throw new RuntimeException('Safari destination changed while image seed waited for locks: '.$target['slug']);}
        $lockedPlan=ts_safari_image_seed_plan($manifest,$landing,$snapshot_hash);
        if(($lockedPlan['action']??'')!=='seed')throw new RuntimeException('Safari image-seed targets changed after dry-run; refusing stale apply.');
        $pageWriteStarted=true;
        $seedBackupId=ts_safari_clone_landing(27,$pageBefore,$seedSnapshot['json'],$seedSnapshot['hash'],false);
        ts_safari_image_seed_verify_backup($seedBackupId,$seedSnapshot['hash'],$manifest);
        foreach($destinationTargets as $target){
            $id=(int)$target['post_id'];$key=$target['asset_key'];$attachment=$attachments[$key]??null;
            if(!is_array($attachment)||empty($attachment['id'])||!hash_equals((string)$attachment['url'],(string)($localUrls[$key]??'')))throw new RuntimeException('Verified local destination attachment is missing: '.$key);
            $imageField=get_field_object('field_ts_dest_hero_image',$id,false,false);
            $urlField=get_field_object('field_ts_dest_hero_image_url',$id,false,false);
            if(!is_array($imageField)||($imageField['key']??'')!=='field_ts_dest_hero_image'||($imageField['name']??'')!=='ts_dest_hero_image'||($imageField['type']??'')!=='image'||!is_array($urlField)||($urlField['key']??'')!=='field_ts_dest_hero_image_url'||($urlField['name']??'')!=='ts_dest_hero_image_url'||($urlField['type']??'')!=='url')throw new RuntimeException('Safari destination image ACF schema changed: '.$target['slug']);
            if(update_field('field_ts_dest_hero_image',(int)$attachment['id'],$id)===false&&ts_safari_normalize_field_value('image',get_field('ts_dest_hero_image',$id,false))!==(int)$attachment['id'])throw new RuntimeException('Safari destination image attachment write failed: '.$target['slug']);
            $sourceUrl=get_field('ts_dest_hero_image_url',$id,false);
            if($sourceUrl!==null&&$sourceUrl!==false&&$sourceUrl!==''){
                if($sourceUrl!==$assets[$key]['source_url'])throw new RuntimeException('Safari destination source URL drifted under lock: '.$target['slug']);
                update_field('field_ts_dest_hero_image_url','',$id);
            }
            foreach(['_ts_safari_content_image_owner'=>$manifest['owner'],'_ts_safari_content_image_key'=>$key] as $metaKey=>$value){update_post_meta($id,$metaKey,$value);if(get_post_meta($id,$metaKey,true)!==$value)throw new RuntimeException('Safari destination image ownership read-back failed: '.$target['slug']);}
            clean_post_cache($id);
            $savedImage=ts_safari_normalize_field_value('image',get_field('ts_dest_hero_image',$id,false));$savedUrl=get_field('ts_dest_hero_image_url',$id,false);
            if($savedImage!==(int)$attachment['id']||!($savedUrl===null||$savedUrl===false||$savedUrl===''))throw new RuntimeException('Safari destination image fields failed transactional read-back: '.$target['slug']);
        }
        $resolved=ts_safari_resolve_destination_cards($landing,static fn($slug)=>get_posts(['post_type'=>'ts_destination','post_status'=>'publish','name'=>$slug,'numberposts'=>2,'suppress_filters'=>true]));
        $content=ts_safari_render_landing($landing,$resolved,$localUrls);
        $updated=wp_update_post(wp_slash(['ID'=>27,'post_content'=>$content]),true);
        if(is_wp_error($updated)||(int)$updated!==27)throw new RuntimeException('Safari landing local-media content update failed.');
        foreach(['_ts_safari_image_seed_owner'=>$manifest['owner'],'_ts_safari_image_seed_backup_id'=>(string)$seedBackupId,'_ts_safari_image_seed_backup_hash'=>$seedSnapshot['hash']] as $metaKey=>$value){update_post_meta(27,$metaKey,$value);if(get_post_meta(27,$metaKey,true)!==$value)throw new RuntimeException('Safari image-seed page ownership read-back failed: '.$metaKey);}
        clean_post_cache(27);$candidate=ts_safari_read_landing_page(27);$managedHash=ts_safari_landing_managed_hash($candidate);
        update_post_meta(27,'_ts_safari_landing_managed_hash',$managedHash);clean_post_cache(27);
        $after=ts_safari_read_landing_page(27);
        if(($after['post_content']??'')!==$content||($after['post_status']??'')!=='publish'||!hash_equals($managedHash,ts_safari_landing_managed_hash($after))||get_post_meta(27,'_ts_safari_landing_owner',true)!==$preflight['owner']||(int)get_post_meta(27,'_ts_safari_landing_backup_id',true)!==$preflight['backup_id']||get_post_meta(27,'_ts_safari_landing_snapshot_hash',true)!==$preflight['backup_hash'])throw new RuntimeException('Safari landing/source ownership read-back failed before commit.');
        ts_safari_image_seed_verify_backup($seedBackupId,$seedSnapshot['hash'],$manifest);
        foreach($destinationTargets as $target){$id=(int)$target['post_id'];$key=$target['asset_key'];$attachment=$attachments[$key];if(ts_safari_normalize_field_value('image',get_field('ts_dest_hero_image',$id,false))!==(int)$attachment['id']||get_post_meta($id,'_ts_safari_content_image_owner',true)!==$manifest['owner']||get_post_meta($id,'_ts_safari_content_image_key',true)!==$key||!in_array(get_field('ts_dest_hero_image_url',$id,false),[null,false,''],true)){throw new RuntimeException('Safari destination ownership/image verification failed before commit: '.$target['slug']);}}
        $verified=ts_safari_image_seed_plan($manifest,$landing,$managedHash);$route=ts_safari_landing_plan($landing);
        if(($verified['action']??'')!=='unchanged'||($route['action']??'')!=='unchanged')throw new RuntimeException('Safari image seed did not verify as idempotently unchanged before commit.');
        if($wpdb->query('COMMIT')===false)throw new RuntimeException('Safari image-seed database commit failed.');
        $transactionActive=false;clean_post_cache(27);
    } catch(Throwable $e) {
        $rollback=$transactionActive?$wpdb->query('ROLLBACK'):false;clean_post_cache(27);foreach($destinationTargets as $target)clean_post_cache((int)$target['post_id']);$restored=$rollback!==false;
        if($restored&&$pageWriteStarted){try{$restored=hash_equals($pageSnapshot['hash'],ts_safari_image_seed_snapshot(ts_safari_read_landing_page(27))['hash']);foreach($destinationTargets as $target){$id=(int)$target['post_id'];if(!hash_equals($stateHash($destinationBefore[$id]),$stateHash($readTargetState($id))))$restored=false;}}catch(Throwable $verifyError){$restored=false;}}
        if(!$restored){$quarantine=wp_update_post(wp_slash(['ID'=>27,'post_status'=>'draft']),true);clean_post_cache(27);if(is_wp_error($quarantine)||get_post_status(27)!=='draft')throw new RuntimeException($e->getMessage().' (rollback/read-back failed and page quarantine could not be verified; manual recovery required)',0,$e);throw new RuntimeException($e->getMessage().' (rollback could not be verified; page quarantined as draft; manual recovery required)',0,$e);}
        throw new RuntimeException($e->getMessage().' (database writes rolled back and verified; exact-owned media files retained for safe resume)',0,$e);
    }
    try {
        $verified=ts_safari_image_seed_plan($manifest,$landing,$managedHash);$route=ts_safari_landing_plan($landing);
        if(($verified['action']??'')!=='unchanged'||($route['action']??'')!=='unchanged')throw new RuntimeException('Post-commit safari image-seed read-back is not unchanged.');
    } catch(Throwable $e) {
        $quarantine=wp_update_post(wp_slash(['ID'=>27,'post_status'=>'draft']),true);clean_post_cache(27);
        if(is_wp_error($quarantine)||get_post_status(27)!=='draft')throw new RuntimeException($e->getMessage().' (commit succeeded but read-back failed and page quarantine could not be verified; manual recovery required)',0,$e);
        throw new RuntimeException($e->getMessage().' (commit succeeded but read-back failed; page quarantined as draft for manual recovery)',0,$e);
    }
    return ['action'=>'seeded','assets'=>count($localUrls),'destination_fields'=>count($destinationTargets),'landing_page_id'=>27,'managed_hash'=>$managedHash,'image_seed_backup_id'=>$seedBackupId,'image_seed_backup_hash'=>$seedSnapshot['hash'],'idempotent_readback'=>$verified['action'],'route_readback'=>$route['action']];
}

function ts_safari_image_seed_capture_target(int $id): array {
    $post=get_post($id);if(!$post)throw new RuntimeException('Safari image-seed rollback target disappeared: '.$id);
    return ['post'=>(array)$post,'meta_rows'=>ts_safari_landing_raw_meta_rows($id),'acf_fields'=>['image'=>get_field('ts_dest_hero_image',$id,false),'image_url'=>get_field('ts_dest_hero_image_url',$id,false)]];
}

function ts_safari_image_seed_state_hash(array $state): string {
    $json=wp_json_encode($state,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);if(!is_string($json))throw new RuntimeException('Could not encode safari image-seed recovery state.');return hash('sha256',$json);
}

function ts_safari_image_seed_rollback(array $manifest,array $landing,int $backupId,string $backupHash,string $expectedManagedHash): array {
    return ts_safari_image_seed_with_writer_lock($manifest,static fn()=>ts_safari_image_seed_rollback_locked($manifest,$landing,$backupId,$backupHash,$expectedManagedHash));
}

function ts_safari_image_seed_rollback_locked(array $manifest,array $landing,int $backupId,string $backupHash,string $expectedManagedHash): array {
    global $wpdb;
    ts_safari_validate_image_seed_manifest($manifest,$landing);
    if($backupId<1||!preg_match('/^[a-f0-9]{64}$/',$backupHash)||!preg_match('/^[a-f0-9]{64}$/',$expectedManagedHash))throw new RuntimeException('Safari image rollback requires exact verified backup and managed-state hashes.');
    foreach(['get_field','get_field_object','update_field'] as $function)if(!function_exists($function))throw new RuntimeException('Safari image rollback requires active ACF API: '.$function);
    ts_safari_require_transactional_tables();
    $page=ts_safari_read_landing_page(27);$owner=get_post_meta(27,'_ts_safari_image_seed_owner',true);$savedBackupId=(int)get_post_meta(27,'_ts_safari_image_seed_backup_id',true);$savedBackupHash=get_post_meta(27,'_ts_safari_image_seed_backup_hash',true);$managed=get_post_meta(27,'_ts_safari_landing_managed_hash',true);
    if($owner!==$manifest['owner']||$savedBackupId!==$backupId||!is_string($savedBackupHash)||!hash_equals($savedBackupHash,$backupHash)||!is_string($managed)||!hash_equals($managed,$expectedManagedHash)||!hash_equals($managed,ts_safari_landing_managed_hash($page)))throw new RuntimeException('Safari image rollback ownership, backup identity, or live managed hash does not match.');
    $route=ts_safari_landing_plan($landing);if(($route['action']??'')!=='unchanged'||(int)($route['page_id']??0)!==27)throw new RuntimeException('Safari image rollback requires the intact owned landing route.');
    $recovery=ts_safari_image_seed_verify_backup($backupId,$backupHash,$manifest);$preflight=ts_safari_image_seed_plan($manifest,$landing,$expectedManagedHash);
    if(($preflight['action']??'')!=='unchanged')throw new RuntimeException('Safari image rollback requires the exact verified seeded state; refusing to overwrite drift.');
    $currentPage=$page;$currentPageSnapshot=ts_safari_image_seed_snapshot($currentPage);$destinationTargets=$manifest['landing']['destinations'];$currentDestinations=[];
    foreach($destinationTargets as $target)$currentDestinations[(int)$target['post_id']]=ts_safari_image_seed_capture_target((int)$target['post_id']);
    $recoveryPage=['post'=>$recovery['post'],'meta'=>$recovery['meta'],'meta_rows'=>$recovery['meta_rows']];$expectedPageJson=wp_json_encode($recoveryPage,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);if(!is_string($expectedPageJson))throw new RuntimeException('Safari image rollback page snapshot could not be verified.');$expectedPageHash=hash('sha256',$expectedPageJson);$preSeedManagedHash=$recovery['meta']['_ts_safari_landing_managed_hash'][0]??'';if(!is_string($preSeedManagedHash)||!preg_match('/^[a-f0-9]{64}$/',$preSeedManagedHash))throw new RuntimeException('Safari image rollback snapshot has no valid pre-seed managed-state hash.');
    $targets=[['id'=>27,'type'=>'page','slug'=>'safaris']];foreach($destinationTargets as $target)$targets[]=['id'=>(int)$target['post_id'],'type'=>'ts_destination','slug'=>$target['slug']];usort($targets,static fn($a,$b)=>$a['id']<=>$b['id']);
    if($wpdb->query('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ')===false)throw new RuntimeException('Could not set safari image rollback transaction isolation.');
    if($wpdb->query('START TRANSACTION')===false){$rollback=$wpdb->query('ROLLBACK');if($rollback===false)throw new RuntimeException('Safari image rollback transaction start failed and rollback could not be verified.');throw new RuntimeException('Could not start safari image rollback transaction.');}
    $transactionActive=true;$restoreStarted=false;
    try {
        foreach($targets as $target)ts_safari_image_seed_lock_target((int)$target['id'],$target['type'],$target['slug']);
        $lockedPage=ts_safari_read_landing_page(27);if(!hash_equals($expectedManagedHash,ts_safari_landing_managed_hash($lockedPage))||!hash_equals($currentPageSnapshot['hash'],ts_safari_image_seed_snapshot($lockedPage)['hash']))throw new RuntimeException('Safari landing changed while rollback waited for row locks.');
        foreach($destinationTargets as $target){$id=(int)$target['post_id'];if(!hash_equals(ts_safari_image_seed_state_hash($currentDestinations[$id]),ts_safari_image_seed_state_hash(ts_safari_image_seed_capture_target($id))))throw new RuntimeException('Safari destination changed while rollback waited for locks: '.$target['slug']);}
        $lockedPlan=ts_safari_image_seed_plan($manifest,$landing,$expectedManagedHash);if(($lockedPlan['action']??'')!=='unchanged')throw new RuntimeException('Safari image-seeded state changed under rollback locks.');
        $restoreStarted=true;
        foreach($destinationTargets as $target){$id=(int)$target['post_id'];$state=$recovery['destinations'][$id]??$recovery['destinations'][(string)$id];$imageObject=get_field_object('field_ts_dest_hero_image',$id,false,false);$urlObject=get_field_object('field_ts_dest_hero_image_url',$id,false,false);if(!is_array($imageObject)||($imageObject['key']??'')!=='field_ts_dest_hero_image'||!is_array($urlObject)||($urlObject['key']??'')!=='field_ts_dest_hero_image_url')throw new RuntimeException('Safari destination ACF schema changed during rollback: '.$target['slug']);
            $post=$state['post'];unset($post['meta']);$updated=wp_update_post(wp_slash($post),true);if(is_wp_error($updated)||(int)$updated!==$id)throw new RuntimeException('Safari destination post rollback failed: '.$target['slug']);
            update_field('field_ts_dest_hero_image',$state['acf_fields']['image'],$id);update_field('field_ts_dest_hero_image_url',$state['acf_fields']['image_url'],$id);
            ts_safari_replace_raw_meta_rows($id,$state['meta_rows']);ts_safari_restore_landing_modified_fields($id,$state['post']);clean_post_cache($id);
            if(!hash_equals(ts_safari_image_seed_state_hash($state),ts_safari_image_seed_state_hash(ts_safari_image_seed_capture_target($id))))throw new RuntimeException('Safari destination rollback read-back failed: '.$target['slug']);
        }
        $post=$recovery['post'];unset($post['meta']);$updated=wp_update_post(wp_slash($post),true);if(is_wp_error($updated)||(int)$updated!==27)throw new RuntimeException('Safari landing rollback failed.');
        ts_safari_replace_raw_meta_rows(27,$recovery['meta_rows']);ts_safari_restore_landing_modified_fields(27,$recovery['post']);clean_post_cache(27);
        $restoredPage=ts_safari_read_landing_page(27);if(!hash_equals($expectedPageHash,ts_safari_image_seed_snapshot($restoredPage)['hash']))throw new RuntimeException('Safari full landing rollback read-back failed.');
        foreach($destinationTargets as $target){$id=(int)$target['post_id'];$state=$recovery['destinations'][$id]??$recovery['destinations'][(string)$id];if(!hash_equals(ts_safari_image_seed_state_hash($state),ts_safari_image_seed_state_hash(ts_safari_image_seed_capture_target($id))))throw new RuntimeException('Safari full destination rollback read-back failed: '.$target['slug']);}
        ts_safari_image_seed_verify_backup($backupId,$backupHash,$manifest);
        if($wpdb->query('COMMIT')===false)throw new RuntimeException('Safari image rollback database commit failed.');$transactionActive=false;clean_post_cache(27);foreach($destinationTargets as $target)clean_post_cache((int)$target['post_id']);
    } catch(Throwable $e) {
        $rollback=$transactionActive?$wpdb->query('ROLLBACK'):false;$transactionActive=false;clean_post_cache(27);foreach($destinationTargets as $target)clean_post_cache((int)$target['post_id']);$restored=$rollback!==false;
        if($restored&&$restoreStarted){try{$restored=hash_equals($currentPageSnapshot['hash'],ts_safari_image_seed_snapshot(ts_safari_read_landing_page(27))['hash']);foreach($destinationTargets as $target){$id=(int)$target['post_id'];if(!hash_equals(ts_safari_image_seed_state_hash($currentDestinations[$id]),ts_safari_image_seed_state_hash(ts_safari_image_seed_capture_target($id))))$restored=false;}}catch(Throwable $verifyError){$restored=false;}}
        if(!$restored){$quarantine=wp_update_post(wp_slash(['ID'=>27,'post_status'=>'draft']),true);clean_post_cache(27);if(is_wp_error($quarantine)||get_post_status(27)!=='draft')throw new RuntimeException($e->getMessage().' (rollback/read-back failed and landing quarantine could not be verified; manual recovery required)',0,$e);throw new RuntimeException($e->getMessage().' (rollback could not be verified; landing quarantined as draft; manual recovery required)',0,$e);}
        throw new RuntimeException($e->getMessage().' (image rollback writes rolled back and verified; seeded state preserved)',0,$e);
    }
    try {$after=ts_safari_image_seed_plan($manifest,$landing,$preSeedManagedHash);$afterRoute=ts_safari_landing_plan($landing);if(($after['action']??'')!=='seed'||($afterRoute['action']??'')!=='unchanged')throw new RuntimeException('Safari image rollback post-commit read-back is not the exact pre-seed state.');}
    catch(Throwable $e){$quarantine=wp_update_post(wp_slash(['ID'=>27,'post_status'=>'draft']),true);clean_post_cache(27);if(is_wp_error($quarantine)||get_post_status(27)!=='draft')throw new RuntimeException($e->getMessage().' (rollback commit succeeded but quarantine could not be verified; manual recovery required)',0,$e);throw new RuntimeException($e->getMessage().' (rollback commit read-back failed; landing quarantined as draft)',0,$e);}
    return ['action'=>'rolled-back','landing_page_id'=>27,'destination_fields'=>count($destinationTargets),'backup_id'=>$backupId,'retained_seeded_media'=>count($manifest['assets']),'post_rollback_plan'=>$after['action'],'route_readback'=>$afterRoute['action']];
}
