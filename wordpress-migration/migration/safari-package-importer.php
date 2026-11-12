<?php
/** Create-only, staging-gated importer for two source-verified safari packages. */
if (!defined('ABSPATH')) { exit; }

function ts_safari_allowed_slugs(): array { return ['expected-wildlife-serengeti','ultimate-fly-in-northern-circuit']; }
function ts_safari_field_schema(): array {
    return [
        'ts_tour_duration'=>['text',[]], 'ts_tour_parks'=>['text',[]], 'ts_tour_price'=>['text',[]],
        'ts_tour_price_note'=>['text',[]], 'ts_tour_badge'=>['select',[]], 'ts_tour_pace_level'=>['text',[]],
        'ts_tour_featured'=>['true_false',[]], 'ts_tour_display_order'=>['number',[]], 'ts_tour_hero_image'=>['image',[]],
        'ts_tour_overview'=>['wysiwyg',[]], 'ts_tour_itinerary'=>['repeater',['day'=>'number','title'=>'text','description'=>'textarea','accommodation'=>'text','meals'=>'text','elevation'=>'text','distance'=>'text','habitat'=>'text']],
        'ts_tour_inclusions'=>['repeater',['text'=>'text']], 'ts_tour_exclusions'=>['repeater',['text'=>'text']],
    ];
}
function ts_safari_approved_hero_urls(): array {
    return [
        'expected-wildlife-serengeti'=>'https://tanzaniasensational.com/storage/safari-packages/fFxQ9ijINDkdwdDSy4S0C8HlH7FE5Fn5Hv4LoTgz.jpg',
        'ultimate-fly-in-northern-circuit'=>'https://tanzaniasensational.com/storage/safari-packages/OE8neKtMlYFpRxCbbCio1MdMFNskqgvgMX7uNBr2.jpg',
    ];
}
function ts_safari_hero_upload_base(): string {
    $uploads=wp_upload_dir(null,false);$base=realpath((string)($uploads['basedir']??''));
    if(!is_string($base)||$base==='')throw new RuntimeException('Could not resolve the WordPress upload directory.');
    return $base;
}
function ts_safari_hero_file_path(int $attachment_id): string {
    $file=get_attached_file($attachment_id);$base=ts_safari_hero_upload_base();$real=is_string($file)?realpath($file):false;
    if(!is_string($real)||!str_starts_with($real,$base.DIRECTORY_SEPARATOR))throw new RuntimeException('Safari hero attachment file is missing or outside the WordPress upload directory.');
    return $real;
}
function ts_safari_verify_hero_attachment(int $attachment_id,string $url,string $slug): array {
    $post=get_post($attachment_id);$owner=get_post_meta($attachment_id,'_ts_safari_image_owner',true);$source=get_post_meta($attachment_id,'_ts_safari_image_source',true);$package=get_post_meta($attachment_id,'_ts_safari_image_package',true);$hash=get_post_meta($attachment_id,'_ts_safari_image_hash',true);$state=get_post_meta($attachment_id,'_ts_safari_image_state',true);
    $media_status=$post->post_status??'';if(!$post||($post->post_type??'')!=='attachment'||$owner!=='approved-safari-package-import-v1'||$source!==$url||$package!==$slug||!is_string($hash)||!preg_match('/^[a-f0-9]{64}$/',$hash)||!in_array($state,['reserved','attached'],true)||($state==='reserved'&&$media_status!=='private')||($state==='attached'&&$media_status!=='inherit'))throw new RuntimeException('Safari hero attachment ownership or state collision detected.');
    $file=ts_safari_hero_file_path($attachment_id);$actual=hash_file('sha256',$file);
    if(!is_string($actual)||!hash_equals($hash,$actual))throw new RuntimeException('Owned safari hero attachment content drift detected.');
    return ['id'=>$attachment_id,'file'=>$file,'sha256'=>$hash,'created'=>false];
}
function ts_safari_unlink_upload_file(string $file): void {
    try{$base=ts_safari_hero_upload_base();$real=realpath($file);if(is_string($real)&&str_starts_with($real,$base.DIRECTORY_SEPARATOR)&&is_file($real))@unlink($real);}catch(Throwable $ignored){}
}

function ts_safari_cleanup_new_hero_attachment(int $attachment_id,string $file,array $known_metadata=[]): void {
    $post=get_post($attachment_id);$base=ts_safari_hero_upload_base();$real=is_file($file)?realpath($file):false;
    if(($post&&($post->post_type??'')!=='attachment')||!is_string($real)||!str_starts_with($real,$base.DIRECTORY_SEPARATOR))throw new RuntimeException('Safari hero cleanup refused an unverified attachment path.');
    $files=[$real];$metadata=function_exists('wp_get_attachment_metadata')?wp_get_attachment_metadata($attachment_id):false;
    foreach([$metadata,$known_metadata] as $media_metadata)if(is_array($media_metadata)){if(!empty($media_metadata['original_image']))$files[]=dirname($real).DIRECTORY_SEPARATOR.basename($media_metadata['original_image']);foreach($media_metadata['sizes']??[] as $size)if(!empty($size['file']))$files[]=dirname($real).DIRECTORY_SEPARATOR.basename($size['file']);}
    $deleted=wp_delete_attachment($attachment_id,true);
    if($deleted===false&&get_post($attachment_id))throw new RuntimeException('Safari hero attachment cleanup failed; owned private attachment requires manual recovery.');
    foreach(array_unique($files) as $path)if(is_file($path)&&!@unlink($path))throw new RuntimeException('Safari hero file cleanup failed; owned artifact requires manual recovery.');
    if(get_post($attachment_id))throw new RuntimeException('Safari hero attachment row remains after cleanup.');
    foreach($files as $path)if(is_file($path))throw new RuntimeException('Safari hero attachment file remains after cleanup.');
}
function ts_safari_sideload_hero(string $url,string $slug): array {
    $approved=ts_safari_approved_hero_urls();$u=wp_parse_url($url);
    if(!isset($approved[$slug])||$approved[$slug]!==$url||!is_array($u)||($u['scheme']??'')!=='https'||($u['host']??'')!=='tanzaniasensational.com'||isset($u['port'])||isset($u['user'])||isset($u['pass'])||isset($u['query'])||isset($u['fragment'])||!preg_match('~^/storage/safari-packages/[A-Za-z0-9-]+\\.jpg$~',$u['path']??''))throw new RuntimeException('Safari hero URL is not an exact allowlisted source asset.');
    $existing=get_posts(['post_type'=>'attachment','post_status'=>['draft','inherit','private','publish','pending','future','trash'],'numberposts'=>-1,'meta_key'=>'_ts_safari_image_source','meta_value'=>$url,'suppress_filters'=>true]);
    if(!is_array($existing))throw new RuntimeException('Could not inspect existing safari hero attachments.');
    if(count($existing)>1)throw new RuntimeException('Duplicate safari hero source attachments are ambiguous.');
    if(count($existing)===1)return ts_safari_verify_hero_attachment((int)$existing[0]->ID,$url,$slug);
    if(!function_exists('wp_safe_remote_get'))throw new RuntimeException('WordPress safe HTTP client is unavailable for safari hero import.');
    $response=wp_safe_remote_get($url,['redirection'=>0,'timeout'=>20,'limit_response_size'=>8000001,'headers'=>['Accept'=>'image/jpeg']]);
    if(is_wp_error($response)||wp_remote_retrieve_response_code($response)!==200)throw new RuntimeException('Safari hero HTTP request failed or attempted a redirect.');
    $contentType=strtolower(trim(explode(';',(string)wp_remote_retrieve_header($response,'content-type'))[0]));$body=wp_remote_retrieve_body($response);
    if($contentType!=='image/jpeg'||!is_string($body)||strlen($body)<4||strlen($body)>8000000)throw new RuntimeException('Safari hero response has an invalid content type or size.');
    $image=function_exists('getimagesizefromstring')?@getimagesizefromstring($body):false;
    if(!is_array($image)||($image[2]??null)!==IMAGETYPE_JPEG||($image[0]??0)<1||($image[1]??0)<1||($image[0]*$image[1])>40000000)throw new RuntimeException('Safari hero response is not a valid bounded JPEG image.');
    if(!function_exists('wp_handle_sideload'))require_once ABSPATH.'wp-admin/includes/file.php';
    if(!function_exists('wp_generate_attachment_metadata'))require_once ABSPATH.'wp-admin/includes/image.php';
    if(!function_exists('wp_handle_sideload')||!function_exists('wp_generate_attachment_metadata')||!function_exists('wp_update_attachment_metadata'))throw new RuntimeException('WordPress media upload APIs are unavailable.');
    $hash=hash('sha256',$body);$tmp=wp_tempnam(basename($u['path']));
    if(!is_string($tmp)||$tmp===''||file_put_contents($tmp,$body,LOCK_EX)!==strlen($body)){if(is_string($tmp)&&is_file($tmp))@unlink($tmp);throw new RuntimeException('Could not stage the validated safari hero bytes.');}
    $sideload_file=['name'=>basename($u['path']),'tmp_name'=>$tmp,'type'=>'image/jpeg','error'=>0,'size'=>strlen($body)];
    try{$handled=wp_handle_sideload($sideload_file,['test_form'=>false,'mimes'=>['jpg|jpeg'=>'image/jpeg']]);}catch(Throwable $e){if(is_file($tmp)&&!@unlink($tmp))throw new RuntimeException('Safari temporary hero cleanup failed; manual recovery required.',0,$e);throw $e;}
    if(!is_array($handled)||!empty($handled['error'])||empty($handled['file'])||($handled['type']??'')!=='image/jpeg'){if(is_file($tmp))@unlink($tmp);if(is_array($handled)&&isset($handled['file'])&&is_string($handled['file']))ts_safari_unlink_upload_file($handled['file']);throw new RuntimeException('WordPress rejected the safari hero sideload.');}
    $file=realpath($handled['file']);$upload_base=ts_safari_hero_upload_base();if(!is_string($file)||!str_starts_with($file,$upload_base.DIRECTORY_SEPARATOR))throw new RuntimeException('Sideloaded safari hero path is outside the WordPress upload directory.');$stored_hash=hash_file('sha256',$file);if(!is_string($stored_hash)||!hash_equals($hash,$stored_hash)){if(is_file($file))@unlink($file);throw new RuntimeException('Sideloaded safari hero content verification failed.');}
    $id=wp_insert_attachment(['post_mime_type'=>'image/jpeg','post_title'=>sanitize_file_name(basename($u['path'])),'post_status'=>'private','post_parent'=>0],$file,0,true);
    if(is_wp_error($id)||!is_numeric($id)||(int)$id<1){if(is_file($file))@unlink($file);throw new RuntimeException('Could not create safari hero attachment row.');}$id=(int)$id;
    $generated_metadata=[];
    try {
        foreach(['_ts_safari_image_owner'=>'approved-safari-package-import-v1','_ts_safari_image_source'=>$url,'_ts_safari_image_package'=>$slug,'_ts_safari_image_hash'=>$hash,'_ts_safari_image_state'=>'reserved'] as $key=>$value)if(!add_post_meta($id,$key,$value,true))throw new RuntimeException('Could not store safari hero ownership metadata: '.$key);
        $generated_metadata=wp_generate_attachment_metadata($id,$file);if(!is_array($generated_metadata)||$generated_metadata===[]||(int)($generated_metadata['width']??0)!==(int)$image[0]||(int)($generated_metadata['height']??0)!==(int)$image[1])throw new RuntimeException('Could not generate valid safari hero attachment metadata.');
        wp_update_attachment_metadata($id,$generated_metadata);$stored_metadata=wp_get_attachment_metadata($id);
        if(!is_array($stored_metadata)||(int)($stored_metadata['width']??0)!==(int)$image[0]||(int)($stored_metadata['height']??0)!==(int)$image[1]||($stored_metadata['file']??null)!==($generated_metadata['file']??null)||!is_array($stored_metadata['sizes']??null))throw new RuntimeException('Could not persist or verify safari hero attachment metadata.');
        foreach($generated_metadata['sizes']??[] as $size=>$details){$size_file=$details['file']??null;if(!is_string($size_file)||($stored_metadata['sizes'][$size]['file']??null)!==$size_file||!is_file(dirname($file).DIRECTORY_SEPARATOR.basename($size_file)))throw new RuntimeException('Could not verify generated safari hero image size: '.$size);}
        $verified=ts_safari_verify_hero_attachment($id,$url,$slug);if(($verified['sha256']??'')!==$hash||get_post_meta($id,'_ts_safari_image_state',true)!=='reserved'||(int)($generated_metadata['width']??1)<1||(int)($generated_metadata['height']??1)<1)throw new RuntimeException('Safari hero attachment ownership read-back failed.');
        return ['id'=>$id,'created'=>true,'sha256'=>$hash,'file'=>$file];
    } catch(Throwable $e) {
        try{ts_safari_cleanup_new_hero_attachment($id,$file,is_array($generated_metadata)?$generated_metadata:[]);}catch(Throwable $cleanup){throw new RuntimeException($e->getMessage().' (new owned attachment cleanup is unverified; manual recovery required)',0,$cleanup);}
        throw $e;
    }
}
function ts_safari_expected_fields(array $p, ?int $hero_id=null): array {
    if(!preg_match('/^(From \\$[0-9,]+) per person$/',$p['price'],$price_parts)) throw new RuntimeException('Safari display price must preserve its exact source label.');
    return [
        'ts_tour_duration'=>$p['duration'], 'ts_tour_parks'=>$p['parks'], 'ts_tour_price'=>$price_parts[1], 'ts_tour_price_note'=>'per person',
        'ts_tour_badge'=>$p['badge'], 'ts_tour_pace_level'=>'', 'ts_tour_featured'=>false, 'ts_tour_display_order'=>['ultimate-fly-in-northern-circuit'=>-2,'expected-wildlife-serengeti'=>-1][$p['slug']],
        'ts_tour_hero_image'=>$hero_id??0, 'ts_tour_overview'=>$p['overview'],
        'ts_tour_itinerary'=>array_map(static fn($d)=>['day'=>$d['day'],'title'=>$d['title'],'description'=>$d['description'],'accommodation'=>$d['accommodation'],'meals'=>$d['meals'],'elevation'=>'','distance'=>'','habitat'=>''],$p['itinerary']),
        'ts_tour_inclusions'=>array_map(static fn($x)=>['text'=>$x],$p['inclusions']), 'ts_tour_exclusions'=>array_map(static fn($x)=>['text'=>$x],$p['exclusions']),
    ];
}
function ts_safari_normalize_field_value(string $type, $value, ?string $field_name=null) {
    if($type==='image')return is_numeric($value)&&(int)$value>0?(int)$value:[];
    if($type==='number'){if($value===null||$value==='')return [];return is_numeric($value)?(int)$value:$value;}
    if($type==='true_false'){if($value===null||$value===false||$value==='')return false;return in_array($value,[true,1,'1','true'],true);}
    if($value===null||$value===false||$value==='')return [];
    if($type==='repeater'&&is_array($value)){
        $schema=ts_safari_field_schema();$subtypes=$schema[$field_name][1]??null;if(!is_array($subtypes)||($schema[$field_name][0]??null)!=='repeater')throw new RuntimeException('Safari ACF repeater read-back requires its registered field name.');
        foreach($value as $i=>$row)if(is_array($row)){$normalized=[];foreach($row as $key=>$item){$raw=(string)$key;$name=$raw;$subtype='text';foreach($subtypes as $subname=>$candidateType)if($raw===$subname||str_ends_with($raw,'_'.$subname)){$name=$subname;$subtype=$candidateType;break;}if(array_key_exists($name,$normalized))throw new RuntimeException('Duplicate Safari ACF repeater subfield read-back: '.$field_name.'.'.$name);$normalized[$name]=ts_safari_normalize_field_value($subtype,$item);}ksort($normalized);$value[$i]=$normalized;}
        return $value;
    }
    return $value;
}
function ts_safari_normalize_value($v){if($v===null||$v===false||$v==='')return [];if(is_array($v)){foreach($v as $k=>$x)$v[$k]=ts_safari_normalize_value($x);return $v;}return $v;}
function ts_safari_expected_state(array $p,string $status='publish',?int $hero_id=null): array {
    return ['post_type'=>'ts_tour','post_status'=>$status,'post_name'=>$p['slug'],'post_title'=>$p['title'],'post_excerpt'=>$p['excerpt'],'post_content'=>'','fields'=>ts_safari_expected_fields($p,$hero_id)];
}
function ts_safari_state_hash(array $s): string {foreach($s['fields'] as $name=>$value){$type=ts_safari_field_schema()[$name][0]??'text';$s['fields'][$name]=ts_safari_normalize_field_value($type,$value,$name);}ksort($s['fields']);$json=wp_json_encode($s,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);if(!is_string($json))throw new RuntimeException('Could not encode safari package state.');return hash('sha256',$json);}
function ts_safari_validate_manifest(array $m): void {
    if (($m['manifest_version']??null)!==1 || !isset($m['packages']) || !is_array($m['packages']) || array_column($m['packages'],'slug')!==ts_safari_allowed_slugs()) throw new RuntimeException('Safari manifest must contain exactly the two approved package slugs in order.');
    foreach ($m['packages'] as $p) {
        $u=wp_parse_url((string)($p['source_url']??''));
        if (!is_array($u)||($u['scheme']??'')!=='https'||($u['host']??'')!=='tanzaniasensational.com'||($u['path']??'')!=='/safaris/packages/'.$p['slug']) throw new RuntimeException('Safari package source URL is not the exact approved source route.');
        foreach(['title','excerpt','badge','duration','parks','price','hero_url','overview'] as $k) if(!isset($p[$k])||!is_string($p[$k])||trim($p[$k])==='') throw new RuntimeException('Safari manifest required field missing: '.$p['slug'].':'.$k);
        if(!is_string($p['price'])||!preg_match('/^From \$[0-9,]+ per person$/',$p['price'])) throw new RuntimeException('Safari package price must remain a verbatim starting-price label.');
        if(!in_array($p['badge'],['CLASSIC','SIGNATURE'],true)||$p['duration']!=='4 Days') throw new RuntimeException('Safari package badge or duration is not source-approved.');
        $approvedImages=ts_safari_approved_hero_urls();$image=wp_parse_url($p['hero_url']); if(!isset($approvedImages[$p['slug']])||$approvedImages[$p['slug']]!==$p['hero_url']||!is_array($image)||($image['scheme']??'')!=='https'||($image['host']??'')!=='tanzaniasensational.com'||!str_starts_with($image['path']??'','/storage/safari-packages/')) throw new RuntimeException('Safari hero URL is not an exact allowlisted source asset.');
        if(count($p['itinerary']??[])!==4||count($p['inclusions']??[])<1||count($p['exclusions']??[])<1) throw new RuntimeException('Safari package is missing source-verified itinerary or included/excluded items.');
        foreach($p['itinerary'] as $i=>$d) if(($d['day']??null)!==$i+1||empty($d['title'])||empty($d['description'])||!array_key_exists('accommodation',$d)||!array_key_exists('meals',$d)) throw new RuntimeException('Safari itinerary day is incomplete or unordered.');
    }
}
function ts_safari_validate_landing_manifest(array $m): void {
    $expected=['serengeti','ngorongoro','tarangire','kilimanjaro','lake-manyara','zanzibar','ruaha','nyerere','mahale'];
    if (($m['version']??null)!==1 || ($m['source_url']??'')!=='https://tanzaniasensational.com/safaris' || ($m['h1']??'')!=='Into the Untamed.' || array_column($m['destinations']??[],'slug')!==$expected) throw new RuntimeException('Safari landing manifest identity or exact destination sequence mismatch.');
    foreach($m['destinations'] as $card) {
        foreach(['tag','title','description','slug','image','alt'] as $key) if(!is_string($card[$key]??null)||trim($card[$key])==='') throw new RuntimeException('Safari landing card field missing: '.$key);
        $source=wp_parse_url((string)($card['source_url']??'')); if(!is_array($source)||($source['scheme']??'')!=='https'||($source['host']??'')!=='tanzaniasensational.com'||($source['path']??'')!=='/safaris/destinations/'.$card['slug']||isset($source['port'])) throw new RuntimeException('Safari landing card route does not match source slug.');
        $image=wp_parse_url($card['image']);
        if($card['slug']==='mahale') { if($card['image']!=='https://images.unsplash.com/photo-1520114878144-6123749968dd?w=2000&q=85&auto=format&fit=crop') throw new RuntimeException('Mahale must retain its exact verified source image URL.'); }
        elseif(!is_array($image)||($image['scheme']??'')!=='https'||($image['host']??'')!=='tanzaniasensational.com'||!str_starts_with($image['path']??'','/storage/destinations/')||($image['port']??443)!==443) throw new RuntimeException('Safari destination image must use a verified absolute source asset URL.');
        if(!is_array($image))throw new RuntimeException('Safari destination image URL is malformed.');
    }
    $expectedMetrics=[['value'=>'0','label'=>'NATIONAL PARKS'],['value'=>'0+','label'=>'GUIDED EXPEDITIONS'],['value'=>'0','label'=>'BOUTIQUE CAMPS'],['value'=>'0+','label'=>'SPECIES CATALOGED']];
    $expectedTestimonial=['quote'=>'Watching the Serengeti sunrise from our balloon, followed by a champagne breakfast seamlessly prepared in the bush, felt like a dream.','attribution'=>'SARAH & JAMES W. • LONDON, UK'];
    $expectedBenefits=[['number'=>'01','title'=>'Architected Itineraries','description'=>'Every detail is painstakingly considered—from specialized wildlife mapping to custom cuisine.'],['number'=>'02','title'=>'Locally Born Mastery','description'=>"Our architects were raised here. We don't just guide—we live it."]];
    if(($m['eyebrow']??'')!=='The Expedition Collective'||($m['intro']??'')!=="Architecting bespoke, uncompromising wilderness journeys across East Africa's most legendary landscapes."||($m['metrics']??null)!==$expectedMetrics||($m['testimonial']??null)!==$expectedTestimonial||($m['benefits']??null)!==$expectedBenefits) throw new RuntimeException('Safari landing content differs from the exact source-backed section manifest.');
    if(($m['hero_image']??'')!=='https://images.unsplash.com/photo-1516426122078-c23e76319801?w=2000&q=85&auto=format&fit=crop' || ($m['difference_image']??'')!=='https://images.unsplash.com/photo-1650668302197-7f556c34cb91?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80') throw new RuntimeException('Safari landing source imagery does not match the verified source URLs.');
    if(($m['journey_cta']['label']??'')!=='INITIALIZE YOUR JOURNEY'||($m['journey_cta']['url']??'')!=='/contact') throw new RuntimeException('Safari landing CTA must match the source contact CTA.');
}
function ts_safari_resolve_destination_cards(array $manifest, callable $lookup): array {
    $cards=[]; foreach($manifest['destinations'] as $card) { $matches=$lookup($card['slug']); if(!is_array($matches)||count($matches)!==1) throw new RuntimeException('Safari destination mapping is missing or ambiguous: '.$card['slug']); $post=$matches[0]; if(($post->post_type??'')!=='ts_destination'||($post->post_status??'')!=='publish'||($post->post_name??'')!==$card['slug']) throw new RuntimeException('Safari destination mapping failed exact identity check: '.$card['slug']); $url=get_permalink($post); $u=wp_parse_url($url); if(!is_string($url)||!is_array($u)||($u['scheme']??'')!=='https'||($u['host']??'')!=='test.tanzaniasensational.com'||($u['port']??443)!==443) throw new RuntimeException('Safari destination permalink is not on the approved staging origin: '.$card['slug']); $card['permalink']=$url; $cards[]=$card; } return $cards;
}
function ts_safari_render_landing(array $m, ?array $resolved=null): string {
    ts_safari_validate_landing_manifest($m);
    $canonical=ts_safari_resolve_destination_cards($m,static fn($slug)=>get_posts(['post_type'=>'ts_destination','post_status'=>'publish','name'=>$slug,'numberposts'=>2,'suppress_filters'=>true]));
    $resolved=$resolved??$canonical;
    if(count($resolved)!==count($canonical))throw new RuntimeException('Safari landing requires the exact approved destination card set.');
    foreach($canonical as $index=>$expected){$candidate=$resolved[$index]??null;if(!is_array($candidate))throw new RuntimeException('Safari landing destination card is malformed.');foreach(['tag','title','description','slug','image','alt','source_url'] as $key)if(($candidate[$key]??null)!==($expected[$key]??null))throw new RuntimeException('Safari landing destination identity/content mismatch: '.$key);if(!is_string($candidate['permalink']??null)||!hash_equals($expected['permalink'],$candidate['permalink']))throw new RuntimeException('Safari landing destination permalink does not match its exact published post.');}
    $resolved=$canonical;$e=static fn($v)=>htmlspecialchars((string)$v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');
    $html='<div class="ts-safari-landing"><section class="premium-safari-hero"><div class="premium-safari-bg"><img src="'.$e($m['hero_image']).'" alt="African safari wilderness — lioness on the Serengeti plains at golden hour"><div class="premium-safari-overlay"></div></div><div class="container"><div class="premium-safari-hero-content"><span class="premium-eyebrow">'.$e($m['eyebrow']).'</span><h1 class="premium-hero-title">'.$e($m['h1']).'</h1><p class="premium-hero-subtitle">'.$e($m['intro']).'</p></div></div><div class="premium-stats-strip"><div class="premium-stats-grid">';
    foreach($m['metrics'] as $metric) $html.='<div class="premium-stat-item"><span class="premium-stat-num">'.$e($metric['value']).'</span><span class="premium-stat-label">'.$e($metric['label']).'</span></div>';
    $html.='</div></div></section><section id="expeditions" class="premium-destinations-section"><div class="container"><div class="premium-dest-grid">';
    foreach($resolved as $card) { $u=wp_parse_url($card['permalink']??''); if(!is_array($u)||($u['host']??'')!=='test.tanzaniasensational.com'||($u['scheme']??'')!=='https'||($u['port']??443)!==443) throw new RuntimeException('Unresolved or off-origin staging destination permalink.'); $html.='<div><a class="premium-dest-card" href="'.$e($card['permalink']).'"><div class="premium-dest-img-wrap"><img src="'.$e($card['image']).'" alt="'.$e($card['alt']).'" loading="lazy"><div class="premium-dest-img-overlay"></div></div><div class="premium-dest-content"><span class="premium-dest-tag">'.$e($card['tag']).'</span><h3 class="premium-dest-name">'.$e($card['title']).'</h3><p class="premium-dest-desc">'.$e($card['description']).'</p><div class="premium-dest-link"><span>Detailed Dossier</span></div></div></a></div>'; }
    $t=$m['testimonial']; $html.='</div></div></section><section class="premium-reviews-band"><div class="container"><span class="premium-eyebrow">The Legacy</span><p class="premium-review-quote">“'.$e($t['quote']).'”</p><div class="premium-dest-tag">'.$e($t['attribution']).'</div></div></section><section class="premium-exp-band"><div class="premium-exp-bg"><img src="'.$e($m['difference_image']).'" alt="Tanzania safari experience — guide and traveler observing wildlife on the savanna" loading="lazy"><div class="premium-exp-overlay"></div></div><div class="container premium-exp-container"><div class="premium-exp-left"><span class="premium-eyebrow">The Difference</span><h2 class="premium-exp-title">Experience That Speaks.</h2><a class="premium-exp-cta" href="'.$e($m['journey_cta']['url']).'"><span>'.$e($m['journey_cta']['label']).'</span></a></div><div class="premium-exp-list">';
    foreach($m['benefits'] as $benefit) $html.='<article class="premium-exp-item"><span class="premium-exp-num">'.$e($benefit['number']).'</span><div><h3 class="premium-exp-item-title">'.$e($benefit['title']).'</h3><p class="premium-exp-item-text">'.$e($benefit['description']).'</p></div></article>';
    return $html.'</div></div></section></div>';
}
function ts_safari_expected_route_plan(): array { return ['landing_route'=>'/safaris','landing_page_id'=>27,'landing_action'=>'verified-clone-then-transactional-source-landing-replacement','landing_snapshot_meta'=>'_ts_safari_landing_backup_snapshot','landing_snapshot_hash_meta'=>'_ts_safari_landing_backup_hash','landing_source_h1'=>'Into the Untamed.','source_destination_card_count'=>9,'archive_route'=>'/safaris/packages','archive_action'=>'existing-ts_tour-post-type-rewrite','expected_published_package_count'=>5,'source_package_card_count'=>2,'archive_query'=>'five existing/new published ts_tour posts, new source pair first','single_template'=>'existing single-tour Elementor template','transaction_scope'=>'per-package; verified clone, page replacement, and rollback each use separate transactions','batch_atomic'=>false,'external_hook_side_effects_reversed'=>false,'resume'=>'completed packages unchanged; only remaining packages create; landing last','route_parity'=>'apply-required-not-verified']; }
function ts_safari_landing_raw_meta_rows(int $post_id): array {
    global $wpdb;
    if($post_id<1||!isset($wpdb->postmeta)||!method_exists($wpdb,'prepare')||!method_exists($wpdb,'get_results'))throw new RuntimeException('Could not inspect exact safari landing metadata rows.');
    $rows=$wpdb->get_results($wpdb->prepare("SELECT meta_key, meta_value FROM {$wpdb->postmeta} WHERE post_id=%d ORDER BY meta_id ASC",$post_id));
    if(!is_array($rows)||!empty($wpdb->last_error))throw new RuntimeException('Could not read exact safari landing metadata rows.');
    $out=[];
    foreach($rows as $row){if(is_object($row))$row=(array)$row;if(!is_array($row)||!is_string($row['meta_key']??null)||!array_key_exists('meta_value',$row)||!is_string($row['meta_value']))throw new RuntimeException('Safari landing metadata row has an unsupported database shape.');$out[]=['meta_key'=>$row['meta_key'],'meta_value'=>$row['meta_value']];}
    return $out;
}
function ts_safari_replace_raw_meta_rows(int $post_id,array $rows): void {
    global $wpdb;
    if($post_id<1||!isset($wpdb->postmeta)||!method_exists($wpdb,'delete')||!method_exists($wpdb,'insert'))throw new RuntimeException('Could not replace exact safari landing metadata rows.');
    if($wpdb->delete($wpdb->postmeta,['post_id'=>$post_id],['%d'])===false)throw new RuntimeException('Could not clear safari landing metadata rows.');
    foreach($rows as $row){if(!is_array($row)||!is_string($row['meta_key']??null)||!is_string($row['meta_value']??null))throw new RuntimeException('Safari landing snapshot contains an invalid raw metadata row.');if($wpdb->insert($wpdb->postmeta,['post_id'=>$post_id,'meta_key'=>$row['meta_key'],'meta_value'=>$row['meta_value']],['%d','%s','%s'])!==1)throw new RuntimeException('Could not restore exact safari landing metadata row: '.$row['meta_key']);}
    clean_post_cache($post_id);
    if(ts_safari_landing_raw_meta_rows($post_id)!==array_values($rows))throw new RuntimeException('Safari landing raw metadata rows failed read-back.');
}
function ts_safari_restore_landing_modified_fields(int $post_id,array $post): void {
    global $wpdb;
    if(!isset($post['post_modified'],$post['post_modified_gmt'])||!isset($wpdb->posts)||!method_exists($wpdb,'update'))throw new RuntimeException('Safari landing modified timestamps are missing or cannot be restored.');
    if($wpdb->update($wpdb->posts,['post_modified'=>$post['post_modified'],'post_modified_gmt'=>$post['post_modified_gmt']],['ID'=>$post_id],['%s','%s'],['%d'])===false)throw new RuntimeException('Safari landing modified timestamps could not be restored.');
    clean_post_cache($post_id);
}
function ts_safari_landing_snapshot(array $page): array {
    if ((int)($page['ID'] ?? 0) !== 27 || ($page['post_type'] ?? '') !== 'page' || ($page['post_name'] ?? '') !== 'safaris' || ($page['post_status']??'')!=='publish') throw new RuntimeException('Safari landing snapshot target is not the approved published page 27.');
    $meta = $page['meta'] ?? []; $elementor = $meta['_elementor_data'] ?? null;
    if (is_array($elementor) && count($elementor)===1) $elementor=$elementor[0];
    if (!is_string($elementor) || $elementor === '') throw new RuntimeException('Safari landing page has no Elementor payload to preserve.');
    $tree = json_decode($elementor, true); if (!is_array($tree)) throw new RuntimeException('Safari landing Elementor payload is not valid JSON.');
    $archiveWidgets=[]; $walk=static function($nodes) use (&$walk,&$archiveWidgets): void { if(!is_array($nodes))return; if(($nodes['widgetType']??'')==='ts_tour_archive')$archiveWidgets[]=$nodes; foreach($nodes as $value)if(is_array($value))$walk($value); }; $walk($tree);
    if(count($archiveWidgets)!==1)throw new RuntimeException('Safari landing page must contain exactly one reviewed ts_tour_archive widget.');
    $settings=$archiveWidgets[0]['settings']??[]; $cta=$settings['show_cta']??null;
    if((int)($settings['count']??0)!==-1||!in_array($cta,[true,1,'1','yes','on'],true))throw new RuntimeException('Safari landing ts_tour_archive widget settings differ from the reviewed count=-1 / CTA-enabled state.');
    $post=$page; unset($post['meta']); ksort($post); ksort($meta);
    $snapshot = ['post'=>$post,'meta'=>$meta,'meta_rows'=>ts_safari_landing_raw_meta_rows((int)$page['ID'])];
    $json = wp_json_encode($snapshot, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);
    if (!is_string($json)) throw new RuntimeException('Could not encode safari landing snapshot.');
    return ['json'=>$json,'hash'=>hash('sha256',$json)];
}
function ts_safari_guard_landing_snapshot(array $current, string $expected_hash): void {
    try { $actual = ts_safari_landing_snapshot($current); } catch(Throwable $e) { throw new RuntimeException('Safari landing page 27 changed since its reviewed preservation snapshot; refusing route apply.',0,$e); }
    if ($expected_hash === '' || !preg_match('/^[a-f0-9]{64}$/',$expected_hash) || !hash_equals($expected_hash, $actual['hash'])) throw new RuntimeException('Safari landing page 27 changed since its reviewed preservation snapshot; refusing route apply.');
}
function ts_safari_read_landing_page(int $id): array {
    $post=get_post($id); if(!$post)return [];
    $meta=get_post_meta($id,'',false); return array_merge((array)$post,['meta'=>is_array($meta)?$meta:[]]);
}
function ts_safari_clone_landing(int $page_id, array $current, string $snapshot_json, string $snapshot_hash): int {
    global $wpdb;
    $snapshot=json_decode($snapshot_json,true);
    if(!is_array($snapshot)||!is_array($snapshot['meta']??null)||!is_array($snapshot['meta_rows']??null)||!hash_equals($snapshot_hash,hash('sha256',$snapshot_json)))throw new RuntimeException('Safari landing clone received an invalid preservation snapshot.');
    $reserved_keys=['_ts_safari_landing_backup_snapshot','_ts_safari_landing_backup_hash'];
    foreach($reserved_keys as $key)if(array_key_exists($key,$snapshot['meta']))throw new RuntimeException('Safari landing source uses a reserved safari landing backup metadata key: '.$key);
    foreach($snapshot['meta_rows'] as $row){if(!is_array($row)||!is_string($row['meta_key']??null))throw new RuntimeException('Safari landing clone snapshot contains an invalid raw metadata row.');if(in_array($row['meta_key'],$reserved_keys,true))throw new RuntimeException('Safari landing source uses a reserved safari landing backup metadata key: '.$row['meta_key']);}
    ts_safari_require_transactional_tables();
    if($wpdb->query('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ')===false||$wpdb->query('START TRANSACTION')===false)throw new RuntimeException('Could not start safari landing backup transaction.');
    $active=true;$backup=0;
    try {
        $post_fields=$current;unset($post_fields['ID'],$post_fields['meta']);$post_fields['post_status']='draft';$post_fields['post_name']='safaris-preserved-backup-'.gmdate('YmdHis').'-'.wp_generate_password(6,false,false);
        $created=wp_insert_post(wp_slash($post_fields),true);
        if(is_wp_error($created)||!is_numeric($created)||(int)$created<1)throw new RuntimeException('Could not create private draft backup of safari page 27.');$backup=(int)$created;
        ts_safari_replace_raw_meta_rows($backup,$snapshot['meta_rows']);
        ts_safari_restore_landing_modified_fields($backup,$current);
        if(update_post_meta($backup,'_ts_safari_landing_backup_snapshot',wp_slash($snapshot_json))===false||update_post_meta($backup,'_ts_safari_landing_backup_hash',$snapshot_hash)===false)throw new RuntimeException('Safari page backup snapshot metadata could not be stored.');
        $read=ts_safari_read_landing_page($backup);$meta=$read['meta']??[];
        if(($read['post_status']??'')!=='draft'||($read['post_name']??'')===($current['post_name']??''))throw new RuntimeException('Safari page backup clone failed identity read-back.');
        foreach(($current['meta']??[]) as $key=>$values){if(!is_array($values))$values=[$values];if(($meta[$key]??[])!==$values)throw new RuntimeException('Safari page backup metadata mismatch: '.$key);}
        foreach($current as $key=>$value)if(!in_array($key,['ID','meta','post_status','post_name'],true)&&($read[$key]??null)!==$value)throw new RuntimeException('Safari page backup post-field mismatch: '.$key);
        $actual_rows=ts_safari_landing_raw_meta_rows($backup);$actual_source_rows=array_values(array_filter($actual_rows,static fn($row)=>!in_array($row['meta_key'],['_ts_safari_landing_backup_snapshot','_ts_safari_landing_backup_hash'],true)));
        if($actual_source_rows!==$snapshot['meta_rows'])throw new RuntimeException('Safari page backup raw metadata rows differ from the source snapshot.');
        $savedSnapshot=get_post_meta($backup,'_ts_safari_landing_backup_snapshot',true);$savedHash=get_post_meta($backup,'_ts_safari_landing_backup_hash',true);
        if(!is_string($savedSnapshot)||!hash_equals($snapshot_json,$savedSnapshot)||!is_string($savedHash)||!hash_equals($snapshot_hash,$savedHash)||!hash_equals($snapshot_hash,hash('sha256',$savedSnapshot)))throw new RuntimeException('Safari page backup snapshot bytes or hash failed read-back.');
        if($wpdb->query('COMMIT')===false)throw new RuntimeException('Safari landing backup transaction commit failed.');$active=false;clean_post_cache($backup);return $backup;
    }catch(Throwable $e){
        $rolled=$active?$wpdb->query('ROLLBACK'):false;clean_post_cache($backup);
        if($active&&$rolled===false)throw new RuntimeException($e->getMessage().' (backup transaction rollback failed; inspect staging before retrying)',0,$e);
        throw $e;
    }
}
function ts_safari_landing_managed_hash(array $page): string {
    $post=$page;unset($post['meta']);ksort($post);$meta=$page['meta']??[];unset($meta['_ts_safari_landing_managed_hash']);ksort($meta);$rows=array_values(array_filter(ts_safari_landing_raw_meta_rows((int)($page['ID']??0)),static fn($row)=>$row['meta_key']!=='_ts_safari_landing_managed_hash'));$json=wp_json_encode(['post'=>$post,'meta'=>$meta,'meta_rows'=>$rows],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);if(!is_string($json))throw new RuntimeException('Could not encode managed safari landing state.');return hash('sha256',$json);
}
function ts_safari_lock_landing_page(int $page_id): array {
    global $wpdb;
    $posts=$wpdb->posts;$meta=$wpdb->postmeta;$row=$wpdb->get_row($wpdb->prepare("SELECT ID FROM {$posts} WHERE ID=%d FOR UPDATE",$page_id));$locked_id=is_object($row)?(int)($row->ID??0):(is_array($row)?(int)($row['ID']??0):0);
    if($locked_id!==$page_id)throw new RuntimeException('Could not lock safari landing page '.$page_id.'.');
    $wpdb->get_results($wpdb->prepare("SELECT meta_id FROM {$meta} WHERE post_id=%d ORDER BY meta_id FOR UPDATE",$page_id));if(!empty($wpdb->last_error))throw new RuntimeException('Could not lock safari landing metadata range.');
    $current=ts_safari_read_landing_page($page_id);if(!$current)throw new RuntimeException('Safari landing page disappeared while locking.');return $current;
}
function ts_safari_lock_landing_snapshot(int $page_id,string $expected_hash): array {
    $current=ts_safari_lock_landing_page($page_id);ts_safari_guard_landing_snapshot($current,$expected_hash);return $current;
}
function ts_safari_apply_landing(int $page_id, array $manifest, string $expected_hash, ?array $resolved=null): array {
    global $wpdb;
    if($page_id!==27) throw new RuntimeException('Safari landing target must be page 27.');
    $current=ts_safari_read_landing_page($page_id); if(!$current)throw new RuntimeException('Safari landing page 27 is missing.');
    ts_safari_guard_landing_snapshot($current,$expected_hash); $snapshot=ts_safari_landing_snapshot($current);
    $resolved=$resolved??ts_safari_resolve_destination_cards($manifest,static fn($slug)=>get_posts(['post_type'=>'ts_destination','post_status'=>'publish','name'=>$slug,'numberposts'=>2,'suppress_filters'=>true]));
    $html=ts_safari_render_landing($manifest,$resolved);
    $backup=ts_safari_clone_landing($page_id,$current,$snapshot['json'],$snapshot['hash']);
    if($wpdb->query('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ')===false||$wpdb->query('START TRANSACTION')===false)throw new RuntimeException('Could not start safari landing replacement transaction.');
    $write_started=false;
    try {
        $current=ts_safari_lock_landing_snapshot($page_id,$expected_hash);$write_started=true;
        $updated=wp_update_post(wp_slash(['ID'=>$page_id,'post_title'=>$manifest['h1'],'post_content'=>$html]),true);
        if(is_wp_error($updated)||(int)$updated!==$page_id)throw new RuntimeException('Safari landing page content replacement failed.');
        foreach(array_keys($current['meta']) as $key) if(str_starts_with($key,'_elementor')) delete_post_meta($page_id,$key);
        foreach(['_ts_safari_landing_owner'=>'approved-safari-landing-import-v1','_ts_safari_landing_snapshot_hash'=>$snapshot['hash'],'_ts_safari_landing_backup_id'=>(string)$backup] as $key=>$value) if(update_post_meta($page_id,$key,$value)===false)throw new RuntimeException('Safari landing ownership metadata write failed: '.$key);
        clean_post_cache($page_id); $candidate=ts_safari_read_landing_page($page_id);$managedHash=ts_safari_landing_managed_hash($candidate);if(update_post_meta($page_id,'_ts_safari_landing_managed_hash',$managedHash)===false)throw new RuntimeException('Safari landing managed-state hash write failed.');
        clean_post_cache($page_id);
        $after=ts_safari_read_landing_page($page_id);
        if(($after['post_title']??'')!==$manifest['h1']||($after['post_content']??'')!==$html||($after['post_status']??'')!=='publish'||isset($after['meta']['_elementor_data']))throw new RuntimeException('Safari landing page read-back failed before commit.');
        if($wpdb->query('COMMIT')===false)throw new RuntimeException('Safari landing replacement commit failed.');
    } catch(Throwable $e) {
        $rolled=$wpdb->query('ROLLBACK');clean_post_cache($page_id);
        if(!$write_started){if($rolled===false)throw new RuntimeException($e->getMessage().' (pre-write rollback failed; preserve current editor state and inspect the database)',0,$e);throw $e;}
        $after=ts_safari_read_landing_page($page_id);$restored=false;
        if($rolled!==false){try{$restored=hash_equals($snapshot['hash'],ts_safari_landing_snapshot($after)['hash']);}catch(Throwable $ignored){$restored=false;}}
        if(!$restored){wp_update_post(wp_slash(['ID'=>$page_id,'post_status'=>'draft']),true);clean_post_cache($page_id);if(get_post_status($page_id)!=='draft')throw new RuntimeException($e->getMessage().' (rollback failed and page quarantine could not be verified)',0,$e);throw new RuntimeException($e->getMessage().' (page quarantined as draft; manual recovery required)',0,$e);}
        throw $e;
    }
    return ['action'=>'landing-applied','page_id'=>$page_id,'backup_id'=>$backup,'backup_status'=>'draft','snapshot_hash'=>$snapshot['hash'],'destination_count'=>count($resolved),'route_parity'=>'apply-readback-pending-browser'];
}
function ts_safari_rollback_landing(int $page_id,int $backup_id,string $expected_hash): array {
    global $wpdb;
    if($page_id!==27)throw new RuntimeException('Safari rollback target must be page 27.');
    ts_safari_require_transactional_tables();
    ts_safari_verify_landing_backup($backup_id,$expected_hash);
    $current=ts_safari_read_landing_page($page_id);$owner=$current['meta']['_ts_safari_landing_owner'][0]??'';$saved=$current['meta']['_ts_safari_landing_snapshot_hash'][0]??'';$linked=(int)($current['meta']['_ts_safari_landing_backup_id'][0]??0);
    if($owner!=='approved-safari-landing-import-v1'||!hash_equals($expected_hash,(string)$saved)||$linked!==$backup_id)throw new RuntimeException('Current landing ownership does not match verified rollback clone.');
    $managed=$current['meta']['_ts_safari_landing_managed_hash'][0]??'';if(!is_string($managed)||!preg_match('/^[a-f0-9]{64}$/',$managed)||!hash_equals($managed,ts_safari_landing_managed_hash($current)))throw new RuntimeException('Safari landing editor drift detected; refusing rollback over unreviewed changes.');
    $json=get_post_meta($backup_id,'_ts_safari_landing_backup_snapshot',true);$snapshot=json_decode($json,true);$post=$snapshot['post']??null;$meta_rows=$snapshot['meta_rows']??null;
    if(!is_array($post)||!is_array($meta_rows))throw new RuntimeException('Safari landing rollback snapshot is missing exact post or metadata rows.');
    if($wpdb->query('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ')===false||$wpdb->query('START TRANSACTION')===false)throw new RuntimeException('Could not start safari landing rollback transaction.');
    $write_started=false;
    try {
        $locked=ts_safari_lock_landing_page($page_id);if(!hash_equals($managed,ts_safari_landing_managed_hash($locked)))throw new RuntimeException('Safari landing changed while rollback was waiting for its lock.');$write_started=true;
        $fields=$post;unset($fields['ID']);$fields['ID']=$page_id;
        $updated=wp_update_post(wp_slash($fields),true);if(is_wp_error($updated)||(int)$updated!==$page_id)throw new RuntimeException('Safari landing rollback post restore failed.');
        ts_safari_restore_landing_modified_fields($page_id,$post);
        ts_safari_replace_raw_meta_rows($page_id,$meta_rows);
        clean_post_cache($page_id);$restored=ts_safari_read_landing_page($page_id);$actual=ts_safari_landing_snapshot($restored);
        if(!hash_equals($expected_hash,$actual['hash']))throw new RuntimeException('Safari landing rollback read-back mismatch.');
        ts_safari_verify_landing_backup($backup_id,$expected_hash);
        if($wpdb->query('COMMIT')===false)throw new RuntimeException('Safari landing rollback commit failed.');
        return ['action'=>'rolled-back','page_id'=>$page_id,'backup_id'=>$backup_id,'snapshot_hash'=>$expected_hash];
    }catch(Throwable $e){
        $rolled=$wpdb->query('ROLLBACK');clean_post_cache($page_id);
        if(!$write_started){if($rolled===false)throw new RuntimeException($e->getMessage().' (pre-write rollback failed; preserve current editor state and inspect the database)',0,$e);throw $e;}
        $after=ts_safari_read_landing_page($page_id);$restored=false;if($rolled!==false){try{$restored=hash_equals($managed,ts_safari_landing_managed_hash($after));}catch(Throwable $ignored){$restored=false;}}
        if(!$restored){wp_update_post(wp_slash(['ID'=>$page_id,'post_status'=>'draft']),true);clean_post_cache($page_id);if(get_post_status($page_id)!=='draft')throw new RuntimeException($e->getMessage().' (rollback failed and landing could not be quarantined)',0,$e);throw new RuntimeException($e->getMessage().' (rollback failed; landing quarantined as draft for manual recovery)',0,$e);}
        throw $e;
    }
}
function ts_safari_validate_run_mode(bool $apply,bool $confirm,bool $admin,string $origin,$public): bool {
    if(rtrim($origin,'/')!=='https://test.tanzaniasensational.com') throw new RuntimeException('Safari importer is restricted to the exact HTTPS staging origin.');
    if((string)$public!=='0') throw new RuntimeException('Safari importer refuses an indexable staging site.');
    if($confirm&&!$apply) throw new RuntimeException('Safari write confirmation requires apply mode.');
    if($apply&&(!$confirm||!$admin)) throw new RuntimeException('Safari apply requires administrator capability and explicit confirmation.');
    return true;
}
function ts_safari_validate_acf_schema(callable $lookup): void {
    foreach(ts_safari_field_schema() as $name=>[$type,$subs]) { $f=$lookup('field_'.$name); if(!is_array($f)||($f['name']??'')!==$name||($f['type']??'')!==$type) throw new RuntimeException('Safari ACF field schema mismatch: '.$name); $actual=[]; foreach($f['sub_fields']??[] as $sf) $actual[$sf['name']]=$sf['type']; if($actual!==$subs) throw new RuntimeException('Safari ACF repeater schema mismatch: '.$name); }
}
function ts_safari_current_state(int $id): array {
    $p=get_post($id); if(!$p||$p->post_type!=='ts_tour') throw new RuntimeException('Safari package read-back failed.'); $fields=[]; foreach(ts_safari_field_schema() as $n=>$_) $fields[$n]=get_field($n,$id,false);
    return ['post_type'=>$p->post_type,'post_status'=>$p->post_status,'post_name'=>$p->post_name,'post_title'=>$p->post_title,'post_excerpt'=>$p->post_excerpt,'post_content'=>$p->post_content,'fields'=>$fields];
}
function ts_safari_plan(array $m): array {
    $posts=get_posts(['post_type'=>'ts_tour','post_status'=>'any','numberposts'=>-1,'suppress_filters'=>true]);$by=[];foreach($posts as $p)$by[$p->post_name][]=$p;$plan=[];
    foreach($m['packages'] as $p){$matches=$by[$p['slug']]??[];if(!$matches){$plan[]=['action'=>'create','slug'=>$p['slug']];continue;}if(count($matches)!==1)throw new RuntimeException('Duplicate safari package slug.');$post=$matches[0];$owner=get_post_meta($post->ID,'_ts_safari_package_owner',true);$snapshot=get_post_meta($post->ID,'_ts_safari_package_snapshot',true);$hash=get_post_meta($post->ID,'_ts_safari_package_hash',true);if($owner!=='approved-safari-package-import-v1'||!is_string($snapshot)||$snapshot===''||!is_string($hash)||!hash_equals($hash,hash('sha256',$snapshot)))throw new RuntimeException('Unowned safari package slug collision: '.$p['slug']);$hero_id=(int)get_field('ts_tour_hero_image',(int)$post->ID,false);if($hero_id<1)throw new RuntimeException('Owned safari package hero image is missing or is not an attachment ID: '.$p['slug']);ts_safari_verify_hero_attachment($hero_id,$p['hero_url'],$p['slug']);$hero_post=get_post($hero_id);if(!$hero_post||$hero_post->post_status!=='inherit'||(int)$hero_post->post_parent!==(int)$post->ID||get_post_meta($hero_id,'_ts_safari_image_state',true)!=='attached')throw new RuntimeException('Owned safari package hero attachment is not bound to its package: '.$p['slug']);$expected=ts_safari_expected_state($p,'publish',$hero_id);$saved=json_decode($snapshot,true);if(!is_array($saved)||!hash_equals(ts_safari_state_hash($expected),ts_safari_state_hash($saved))||!hash_equals(ts_safari_state_hash($expected),ts_safari_state_hash(ts_safari_current_state((int)$post->ID))))throw new RuntimeException('Safari package editor drift detected: '.$p['slug']);$plan[]=['action'=>'unchanged','slug'=>$p['slug'],'post_id'=>(int)$post->ID,'attachment_id'=>$hero_id];}
    return $plan;
}
function ts_safari_backup_is_outside_root(string $backup,string $root): bool {
    $backup=rtrim($backup,DIRECTORY_SEPARATOR);$root=rtrim($root,DIRECTORY_SEPARATOR);
    return $backup!==$root&&!str_starts_with($backup,$root.DIRECTORY_SEPARATOR);
}
function ts_safari_verify_backup(string $dir): void {
    $required=['database.sql','custom-plugins.tgz','plugin-inventory.txt','theme-inventory.txt','SHA256SUMS'];
    $resolved=realpath($dir);$root=realpath(ABSPATH);
    if(!is_string($resolved)||!is_string($root)||!ts_safari_backup_is_outside_root($resolved,$root)) throw new RuntimeException('Safari backup must exist outside the public WordPress root.');
    if(!preg_match('/(?:^|-)\d{8}T\d{6}Z(?:-|$)/',basename($resolved))) throw new RuntimeException('Safari backup directory must carry a dated UTC identifier.');
    foreach(array_slice($required,0,4) as $file) if(!is_file($resolved.'/'.$file)||filesize($resolved.'/'.$file)<1) throw new RuntimeException('Safari backup is missing required file: '.$file);
    if((fileperms($resolved)&0777)!==0700) throw new RuntimeException('Safari backup directory mode must be 700.');
    $newest=0;foreach($required as $file){if((fileperms($resolved.'/'.$file)&0777)!==0600)throw new RuntimeException('Safari backup files must have mode 600: '.$file);if($file!=='SHA256SUMS')$newest=max($newest,(int)filemtime($resolved.'/'.$file));}
    if($newest>time()+60||time()-$newest>86400) throw new RuntimeException('Safari backup is stale; create a fresh backup within 24 hours before apply.');
    $sql=file_get_contents($resolved.'/database.sql');if(!is_string($sql)||!preg_match('/CREATE\s+TABLE/i',$sql))throw new RuntimeException('Safari database backup is not readable as a SQL dump.');
    try{$archive=new PharData($resolved.'/custom-plugins.tgz');if(count($archive)<1)throw new RuntimeException('Safari custom plugin archive is empty.');}catch(Throwable $e){throw new RuntimeException('Safari custom plugin archive integrity check failed.',0,$e);}
    $manifest=file($resolved.'/SHA256SUMS',FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES); if(!is_array($manifest)) throw new RuntimeException('Safari backup checksum manifest is unreadable.');
    foreach(array_slice($required,0,4) as $file) { $found=false; foreach($manifest as $line) if(preg_match('/^([a-f0-9]{64})\s+\*?'.preg_quote($file,'/').'$/',$line,$m)) { $found=hash_equals($m[1],hash_file('sha256',$resolved.'/'.$file)); break; } if(!$found) throw new RuntimeException('Safari backup checksum is missing or invalid: '.$file); }
}
function ts_safari_require_transactional_tables(): void {
    global $wpdb;
    if(!isset($wpdb->posts,$wpdb->postmeta)||!method_exists($wpdb,'get_var')||!method_exists($wpdb,'prepare'))throw new RuntimeException('Safari migration cannot inspect transaction table engines.');
    foreach(array_unique([$wpdb->posts,$wpdb->postmeta]) as $table){$engine=$wpdb->get_var($wpdb->prepare('SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=%s',$table));if(strtoupper(trim((string)$engine))!=='INNODB')throw new RuntimeException('Safari import requires InnoDB table: '.$table);}
}
function ts_safari_apply_package(array $p): array {
    global $wpdb;
    $hero=ts_safari_sideload_hero($p['hero_url'],$p['slug']);$hero_id=(int)($hero['id']??0);$hero_post=get_post($hero_id);$active=false;$id=0;
    try {
        if($hero_id<1||!$hero_post||($hero_post->post_type??'')!=='attachment'||($hero_post->post_status??'')!=='private'||get_post_meta($hero_id,'_ts_safari_image_state',true)!=='reserved')throw new RuntimeException('Safari package hero attachment is not a reusable private reservation.');
        if($wpdb->query('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ')===false)throw new RuntimeException('Could not set safari package transaction isolation.');
        if($wpdb->query('START TRANSACTION')===false){if($wpdb->query('ROLLBACK')===false)throw new RuntimeException('Safari transaction start failed and rollback could not be verified.');throw new RuntimeException('Could not start safari package transaction.');}
        $active=true;$table=$wpdb->posts;$q=$wpdb->prepare("SELECT ID FROM {$table} FORCE INDEX (post_name) WHERE post_name = %s AND post_type = %s LIMIT 1 FOR UPDATE",$p['slug'],'ts_tour');$found=$wpdb->get_var($q);
        if($found===false||!empty($wpdb->last_error))throw new RuntimeException('Could not lock safari package slug: '.$p['slug']);
        if($found!==null)throw new RuntimeException('Safari package slug collision appeared after preflight: '.$p['slug']);
        $id=wp_insert_post(wp_slash(['post_type'=>'ts_tour','post_status'=>'draft','post_name'=>$p['slug'],'post_title'=>$p['title'],'post_excerpt'=>$p['excerpt'],'post_content'=>'','comment_status'=>'closed','ping_status'=>'closed']),true);
        if(is_wp_error($id)||!is_numeric($id)||(int)$id<1)throw new RuntimeException('Could not create safari package draft: '.$p['slug']);$id=(int)$id;
        foreach(ts_safari_expected_fields($p,$hero_id) as $name=>$value)if(update_field('field_'.$name,$value,$id)===false)throw new RuntimeException('Could not write safari ACF field: '.$name);
        clean_post_cache($id);$draft=ts_safari_expected_state($p,'draft',$hero_id);if(!hash_equals(ts_safari_state_hash($draft),ts_safari_state_hash(ts_safari_current_state($id))))throw new RuntimeException('Safari package draft read-back failed: '.$p['slug']);
        $attached=wp_update_post(wp_slash(['ID'=>$hero_id,'post_status'=>'inherit','post_parent'=>$id]),true);if(is_wp_error($attached)||(int)$attached!==$hero_id)throw new RuntimeException('Could not bind safari hero attachment to its package.');
        if(update_post_meta($hero_id,'_ts_safari_image_state','attached')===false||get_post_meta($hero_id,'_ts_safari_image_state',true)!=='attached')throw new RuntimeException('Safari hero attachment state failed read-back.');
        $hero_post=get_post($hero_id);if(!$hero_post||$hero_post->post_status!=='inherit'||(int)$hero_post->post_parent!==$id)throw new RuntimeException('Safari hero attachment parent/status read-back failed.');ts_safari_verify_hero_attachment($hero_id,$p['hero_url'],$p['slug']);
        $expected=ts_safari_expected_state($p,'publish',$hero_id);$json=wp_json_encode($expected,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);if(!is_string($json))throw new RuntimeException('Could not encode safari ownership snapshot.');
        foreach(['_ts_safari_package_owner'=>'approved-safari-package-import-v1','_ts_safari_package_snapshot'=>$json,'_ts_safari_package_hash'=>hash('sha256',$json)] as $key=>$value){update_post_meta($id,$key,is_string($value)?wp_slash($value):$value);$actual=get_post_meta($id,$key,true);if($actual!==$value&&(string)$actual!==(string)$value)throw new RuntimeException('Safari ownership metadata failed read-back: '.$key);}
        $published=wp_update_post(wp_slash(['ID'=>$id,'post_status'=>'publish']),true);if(is_wp_error($published)||(int)$published!==$id)throw new RuntimeException('Could not publish verified safari package.');clean_post_cache($id);
        if(!hash_equals(ts_safari_state_hash($expected),ts_safari_state_hash(ts_safari_current_state($id))))throw new RuntimeException('Safari package publish read-back failed: '.$p['slug']);
        if($wpdb->query('COMMIT')===false)throw new RuntimeException('Safari package transaction commit failed.');$active=false;clean_post_cache($id);return ['action'=>'created','slug'=>$p['slug'],'post_id'=>$id,'attachment_id'=>$hero_id];
    } catch(Throwable $e) {
        if($active){$rollback=$wpdb->query('ROLLBACK');if($rollback===false)throw new RuntimeException($e->getMessage().' (rollback failed; package and media state require manual recovery)',0,$e);clean_post_cache($id);if($id>0&&get_post($id)){$post=get_post($id);if($post&&$post->post_status!=='draft'){wp_update_post(wp_slash(['ID'=>$id,'post_status'=>'draft']),true);clean_post_cache($id);}if(get_post_status($id)!=='draft')throw new RuntimeException($e->getMessage().' (created package could not be quarantined)',0,$e);}}
        if(!empty($hero['created'])){try{ts_safari_cleanup_new_hero_attachment($hero_id,(string)($hero['file']??''));}catch(Throwable $cleanup){throw new RuntimeException($e->getMessage().' (new owned attachment cleanup is unverified; manual recovery required)',0,$cleanup);}}
        throw $e;
    }
}
function ts_safari_expected_archive_order(array $packages, array $legacy): array {
    $source=[]; foreach($packages as $p)$source[]=['slug'=>$p['slug'],'order'=>ts_safari_expected_fields($p)['ts_tour_display_order']];
    usort($source,static fn($a,$b)=>(int)$a['order']<=>(int)$b['order']);
    usort($legacy,static fn($a,$b)=>(int)$a['order']<=>(int)$b['order']);
    return array_merge(array_column($source,'slug'),array_column($legacy,'slug'));
}
function ts_safari_legacy_snapshot(): array {
    $posts=get_posts(['post_type'=>'ts_tour','post_status'=>'publish','numberposts'=>-1,'suppress_filters'=>true]); $by=[];
    foreach($posts as $post)if(in_array((int)$post->ID,[12,13,14],true))$by[(int)$post->ID]=$post;
    if(array_keys($by)!==[12,13,14]) { ksort($by); if(array_keys($by)!==[12,13,14])throw new RuntimeException('Expected published legacy tour posts 12–14 are missing or changed.'); }
    $snapshot=[]; foreach($by as $id=>$post){$data=['post'=>(array)$post,'meta'=>get_post_meta($id,'',false)];$json=wp_json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);$snapshot[$id]=['json'=>$json,'hash'=>hash('sha256',$json),'slug'=>$post->post_name,'order'=>(int)get_field('ts_tour_display_order',$id,false)];} return $snapshot;
}
function ts_safari_verify_archive(array $manifest,array $legacy_before): array {
    $published=get_posts(['post_type'=>'ts_tour','post_status'=>'publish','numberposts'=>-1,'suppress_filters'=>true]);
    if(count($published)!==5)throw new RuntimeException('Safari archive must contain exactly five published tours after preserving legacy records.');
    foreach($legacy_before as $id=>$before){$after=ts_safari_read_tour_snapshot((int)$id);if(!hash_equals($before['hash'],$after['hash']))throw new RuntimeException('Legacy safari tour changed during import: '.$id);}
    $legacy=array_map(static fn($x)=>['slug'=>$x['slug'],'order'=>$x['order']],array_values($legacy_before));
    $order=ts_safari_expected_archive_order($manifest['packages'],$legacy);
    $by=[]; foreach($published as $p){if(isset($by[$p->post_name]))throw new RuntimeException('Safari archive contains duplicate published tour slugs.');$by[$p->post_name]=$p;}
    $expectedSet=$order; $actualSet=array_keys($by); sort($expectedSet);sort($actualSet);if($actualSet!==$expectedSet)throw new RuntimeException('Safari archive exact published slug set differs from approved source and preserved legacy set.');
    $actual=[];foreach($published as $p)$actual[]=['slug'=>$p->post_name,'order'=>(int)get_field('ts_tour_display_order',$p->ID,false)];
    usort($actual,static fn($a,$b)=>$a['order']<=>$b['order']);
    if(array_column($actual,'slug')!==$order)throw new RuntimeException('Safari archive five-card order does not match source-first owner-preserving acceptance.');
    return ['count'=>5,'slugs'=>$order,'legacy_ids_unchanged'=>array_map('intval',array_keys($legacy_before))];
}
function ts_safari_read_tour_snapshot(int $id): array { $p=get_post($id);if(!$p)throw new RuntimeException('Legacy tour disappeared during safari apply: '.$id);$data=['post'=>(array)$p,'meta'=>get_post_meta($id,'',false)];$json=wp_json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);return ['json'=>$json,'hash'=>hash('sha256',$json)]; }
function ts_safari_verify_landing_backup(int $backup_id,string $expected_hash): void {
    if($backup_id<1||get_post_status($backup_id)!=='draft')throw new RuntimeException('Safari landing private backup is missing or no longer draft.');
    $json=get_post_meta($backup_id,'_ts_safari_landing_backup_snapshot',true);$savedHash=get_post_meta($backup_id,'_ts_safari_landing_backup_hash',true);
    if(!is_string($json)||!is_string($savedHash)||!hash_equals($expected_hash,$savedHash)||!hash_equals($expected_hash,hash('sha256',$json)))throw new RuntimeException('Safari landing backup snapshot bytes/hash drifted.');
    $snapshot=json_decode($json,true);$backup=ts_safari_read_landing_page($backup_id);
    if(!is_array($snapshot)||!is_array($snapshot['post']??null)||!is_array($snapshot['meta']??null)||!is_array($snapshot['meta_rows']??null)||!$backup||!str_starts_with((string)($backup['post_name']??''),'safaris-preserved-backup-'))throw new RuntimeException('Safari landing backup identity or snapshot is invalid.');
    foreach($snapshot['post'] as $key=>$value)if(!in_array($key,['ID','post_status','post_name'],true)&&($backup[$key]??null)!==$value)throw new RuntimeException('Safari landing backup post-field drift: '.$key);
    $actualMeta=$backup['meta'];unset($actualMeta['_ts_safari_landing_backup_snapshot'],$actualMeta['_ts_safari_landing_backup_hash']);$expectedMeta=$snapshot['meta'];ksort($actualMeta);ksort($expectedMeta);
    if($actualMeta!==$expectedMeta)throw new RuntimeException('Safari landing backup metadata drifted from its full source snapshot.');
    $actualRows=ts_safari_landing_raw_meta_rows($backup_id);$actualSourceRows=array_values(array_filter($actualRows,static fn($row)=>!in_array($row['meta_key'],['_ts_safari_landing_backup_snapshot','_ts_safari_landing_backup_hash'],true)));
    if($actualSourceRows!==$snapshot['meta_rows'])throw new RuntimeException('Safari landing backup raw metadata rows drifted from its full source snapshot.');
}
function ts_safari_landing_plan(array $manifest): array {
    $page=ts_safari_read_landing_page(27); if(!$page)throw new RuntimeException('Safari landing page 27 is missing.');
    $resolved=ts_safari_resolve_destination_cards($manifest,static fn($slug)=>get_posts(['post_type'=>'ts_destination','post_status'=>'publish','name'=>$slug,'numberposts'=>2,'suppress_filters'=>true]));
    $html=ts_safari_render_landing($manifest,$resolved); $owner=get_post_meta(27,'_ts_safari_landing_owner',true);
    if($owner==='approved-safari-landing-import-v1') {
        $hash=get_post_meta(27,'_ts_safari_landing_snapshot_hash',true);$managedHash=get_post_meta(27,'_ts_safari_landing_managed_hash',true);$backup=(int)get_post_meta(27,'_ts_safari_landing_backup_id',true);
        if(!preg_match('/^[a-f0-9]{64}$/',(string)$hash)||!preg_match('/^[a-f0-9]{64}$/',(string)$managedHash)||!hash_equals((string)$managedHash,ts_safari_landing_managed_hash($page))||($page['post_type']??'')!=='page'||($page['post_name']??'')!=='safaris'||($page['post_status']??'')!=='publish'||($page['post_title']??'')!==$manifest['h1']||($page['post_content']??'')!==$html||get_post_status($backup)!=='draft')throw new RuntimeException('Owned safari landing route drifted; refusing to overwrite.');
        ts_safari_verify_landing_backup($backup,(string)$hash);
        return ['action'=>'unchanged','page_id'=>27,'backup_id'=>$backup,'snapshot_hash'=>$hash];
    }
    $snapshot=ts_safari_landing_snapshot($page); return ['action'=>'replace','page_id'=>27,'snapshot_hash'=>$snapshot['hash'],'destination_count'=>count($resolved)];
}
function ts_safari_parse_cli_flag(array $assoc,string $name): bool {
    if(!array_key_exists($name,$assoc))return false;
    $value=$assoc[$name]; if($value===''||$value===true||$value===1||$value==='1')return true;
    if($value===false||$value===0||$value==='0'||$value==='false')return false;
    throw new RuntimeException('Safari CLI flag has an unsupported boolean value: --'.$name);
}
function ts_safari_apply_landing_after_archive_verification(array $manifest,array $legacy_before,callable $apply_landing): array {
    $archive=ts_safari_verify_archive($manifest,$legacy_before);
    $landing=$apply_landing();
    if(!is_array($landing))throw new RuntimeException('Safari landing apply did not return a verified result.');
    return ['archive'=>$archive,'landing'=>$landing];
}
function ts_safari_import_run(bool $apply=false,bool $confirm=false,string $backup='',string $landing_snapshot_hash=''): array {
    if(!defined('ABSPATH')||!function_exists('home_url'))throw new RuntimeException('Must run inside WordPress.');
    $origin=home_url('/');$public=get_option('blog_public');$admin=current_user_can('manage_options');ts_safari_validate_run_mode($apply,$confirm,$admin,$origin,$public);
    $path=__DIR__.'/safari-package-import-manifest.json';$manifest=json_decode((string)file_get_contents($path),true,512,JSON_THROW_ON_ERROR);ts_safari_validate_manifest($manifest);
    $landingPath=__DIR__.'/safari-landing-manifest.json';$landing=json_decode((string)file_get_contents($landingPath),true,512,JSON_THROW_ON_ERROR);ts_safari_validate_landing_manifest($landing);
    ts_safari_validate_acf_schema(static fn(string $key)=>acf_get_field($key));
    $landingPlan=ts_safari_landing_plan($landing); $plan=ts_safari_plan($manifest);
    if($apply){if($backup==='')throw new RuntimeException('Safari apply requires --backup-dir.');ts_safari_verify_backup($backup);ts_safari_require_transactional_tables();
        $legacyBefore=ts_safari_legacy_snapshot();
        $expectedPublished=array_column($legacyBefore,'slug');foreach($manifest['packages'] as $pkg){$matches=array_filter(get_posts(['post_type'=>'ts_tour','post_status'=>'publish','numberposts'=>-1,'suppress_filters'=>true]),static fn($post)=>$post->post_name===$pkg['slug']);if(count($matches)>1)throw new RuntimeException('Duplicate approved source package slug before apply.');if(count($matches)===1)$expectedPublished[]=$pkg['slug'];}
        $published=get_posts(['post_type'=>'ts_tour','post_status'=>'publish','numberposts'=>-1,'suppress_filters'=>true]);$actualPublished=array_map(static fn($post)=>$post->post_name,$published);$expectedSorted=$expectedPublished;$actualSorted=$actualPublished;sort($expectedSorted);sort($actualSorted);if(count($actualSorted)!==count(array_unique($actualSorted))||$actualSorted!==$expectedSorted)throw new RuntimeException('Published tour slug set differs from the exact approved legacy/source set; refusing before writes.');
        if($landingPlan['action']==='replace'&&!hash_equals($landingPlan['snapshot_hash'],$landing_snapshot_hash))throw new RuntimeException('Safari apply requires the exact landing snapshot hash from the immediately preceding dry-run.');
    }
    $report=['origin'=>$origin,'blog_public'=>$public,'packages'=>$plan,'landing'=>$landingPlan,'routes'=>ts_safari_expected_route_plan()];if(!$apply)return $report;
    $applied=[];foreach($manifest['packages'] as $i=>$p)$applied[]=$plan[$i]['action']==='create'?ts_safari_apply_package($p):$plan[$i];
    $verified=ts_safari_plan($manifest);foreach($verified as $item)if($item['action']!=='unchanged')throw new RuntimeException('Safari post-apply read-back did not plan unchanged: '.$item['slug']);
    $sequenced=ts_safari_apply_landing_after_archive_verification($manifest,$legacyBefore,static fn()=>$landingPlan['action']==='replace'?ts_safari_apply_landing(27,$landing,$landing_snapshot_hash):$landingPlan);
    $landingResult=$sequenced['landing'];
    $archive=ts_safari_verify_archive($manifest,$legacyBefore);
    $finalLanding=ts_safari_landing_plan($landing);if($finalLanding['action']!=='unchanged')throw new RuntimeException('Safari landing post-apply ownership read-back did not plan unchanged.');
    return ['applied'=>$applied,'verification'=>$verified,'landing'=>$landingResult,'landing_verification'=>$finalLanding,'archive'=>$archive,'routes'=>ts_safari_expected_route_plan()];
}
