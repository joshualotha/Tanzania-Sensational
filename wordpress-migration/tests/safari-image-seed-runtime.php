<?php
define('ABSPATH', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR);
function wp_parse_url($url) { return parse_url($url); }
function wp_json_encode($value, $flags = 0) { return json_encode($value, $flags); }
function wp_slash($value) { if(is_string($value))return addslashes($value);if(is_array($value))return array_map('wp_slash',$value);return $value; }
function unslash($value) { if(is_string($value))return stripslashes($value);if(is_array($value))return array_map('unslash',$value);return $value; }
function get_post($id) { return $GLOBALS['safari_posts'][$id] ?? null; }
function get_post_status($id) { return get_post($id)->post_status ?? false; }
function clean_post_cache($id) { unset($GLOBALS['safari_post_cache'][$id]); }
function get_posts($args) {
    $items=array_values(array_filter($GLOBALS['safari_posts']??[],static function($post)use($args){
        if(($post->post_type??'')!==($args['post_type']??''))return false;
        if(isset($args['post_status'])&&$args['post_status']!=='any'&&!in_array($post->post_status??'',(array)$args['post_status'],true))return false;
        if(isset($args['name'])&&($post->post_name??'')!==$args['name'])return false;
        if(isset($args['meta_key'])&&get_post_meta((int)$post->ID,$args['meta_key'],true)!==($args['meta_value']??''))return false;
        return true;
    }));
    if(isset($args['numberposts'])&&$args['numberposts']>0)$items=array_slice($items,0,$args['numberposts']);
    return $items;
}
function get_post_meta($id,$key='',$single=true) {
    if($key===''){$all=[];foreach($GLOBALS['safari_meta'][$id]??[] as $name=>$value)$all[$name]=[$value];return $all;}
    $value=$GLOBALS['safari_meta'][$id][$key]??'';
    return $single?$value:($value===''?[]:[$value]);
}
function update_post_meta($id,$key,$value) { $GLOBALS['safari_meta'][$id][$key]=unslash($value); return true; }
function get_field($key,$id,$format=false) { return $GLOBALS['safari_fields'][$id][$key]??null; }
function update_field($key,$value,$id) { $name=str_starts_with($key,'field_')?substr($key,6):$key;if(($GLOBALS['safari_fail_field_post']??0)===(int)$id&&$name==='ts_dest_hero_image')return false;$GLOBALS['safari_fields'][$id][$name]=$value;return true; }
function get_field_object($selector,$id=false,$format=true,$load=true) { $key=str_starts_with($selector,'field_')?$selector:'field_'.$selector;return match($key){'field_ts_dest_hero_image'=>['key'=>$key,'name'=>'ts_dest_hero_image','type'=>'image'],'field_ts_dest_hero_image_url'=>['key'=>$key,'name'=>'ts_dest_hero_image_url','type'=>'url'],default=>false}; }
function wp_generate_password($length=12,$special_chars=true,$extra_special_chars=false) { return 'imageSeed123'; }
function wp_insert_post($post,$wp_error=false) { $id=++$GLOBALS['safari_next'];$post=unslash($post);$post['ID']=$id;$GLOBALS['safari_posts'][$id]=(object)$post;return $id; }
function wp_update_post($post,$wp_error=false) { $post=unslash($post);$id=(int)($post['ID']??0);if(!isset($GLOBALS['safari_posts'][$id]))return 0;foreach($post as $key=>$value)if($key!=='ID')$GLOBALS['safari_posts'][$id]->{$key}=$value;return $id; }
function wp_get_attachment_url($id) { if(isset($GLOBALS['safari_attachment_urls'][$id]))return $GLOBALS['safari_attachment_urls'][$id];$file=get_attached_file($id);if(!is_string($file))return false;return 'https://test.tanzaniasensational.com/wp-content/uploads/'.basename($file); }
function get_permalink($post) { return 'https://test.tanzaniasensational.com/safaris/destinations/'.$post->post_name.'/'; }
function is_wp_error($value) { return false; }
function sanitize_text_field($value) { return trim(strip_tags((string)$value)); }
class SafariImageSeedDB {
    public $posts='wp_posts'; public $postmeta='wp_postmeta'; public $last_error=''; public $queries=[]; public $engine='InnoDB'; public $transactionActive=false; private $snapshot=null;
    public function prepare($query,...$args) { foreach($args as $arg)$query=preg_replace('/%[sd]/',is_int($arg)?(string)$arg:"'".addslashes((string)$arg)."'",$query,1); return $query; }
    public function query($query) {
        $this->queries[]=$query;
        $this->last_error='';
        if($query==='SET TRANSACTION ISOLATION LEVEL REPEATABLE READ'&&$this->transactionActive){$this->last_error='Transaction characteristics cannot be changed while a transaction is in progress';return false;}
        if($query==='START TRANSACTION'){if($this->transactionActive){$this->last_error='Nested transactions are not supported';return false;}$this->snapshot=serialize([$GLOBALS['safari_posts'],$GLOBALS['safari_meta'],$GLOBALS['safari_fields']]);$this->transactionActive=true;}
        if($query==='ROLLBACK'){if(!empty($GLOBALS['safari_fail_rollback']))return false;if($this->snapshot!==null){[$posts,$meta,$fields]=unserialize($this->snapshot);$GLOBALS['safari_posts']=$posts;$GLOBALS['safari_meta']=$meta;if(empty($GLOBALS['safari_corrupt_rollback_fields']))$GLOBALS['safari_fields']=$fields;$this->snapshot=null;$this->transactionActive=false;}}
        if($query==='COMMIT'){$this->snapshot=null;$this->transactionActive=false;}
        if($query!=='ROLLBACK')$this->last_error='';
        return 1;
    }
    public function get_var($query) { $this->queries[]=$query;if(str_contains($query,'GET_LOCK'))return 1;if(str_contains($query,'RELEASE_LOCK'))return 1;return str_contains($query,'information_schema.TABLES')?$this->engine:null; }
    public function get_row($query) { $this->queries[]=$query;if(!preg_match('/WHERE ID\s*=\s*([0-9]+)/',$query,$match))return null;$id=(int)$match[1];return isset($GLOBALS['safari_posts'][$id])?(object)['ID'=>$id]:null; }
    public function get_results($query) {
        $this->queries[]=$query;
        if(!preg_match('/post_id\s*=\s*\'?([0-9]+)\'?/',$query,$match))return [];
        $rows=[];foreach($GLOBALS['safari_meta'][(int)$match[1]]??[] as $key=>$value)$rows[]=(object)['meta_key'=>$key,'meta_value'=>is_string($value)?$value:serialize($value)];return $rows;
    }
    public function insert($table,$data,$formats=null) { if($table===$this->postmeta){$GLOBALS['safari_meta'][(int)$data['post_id']][$data['meta_key']]=$data['meta_value'];return 1;}return 1; }
    public function delete($table,$where,$formats=null) { if($table===$this->postmeta){unset($GLOBALS['safari_meta'][(int)$where['post_id']]);return 1;}return 1; }
    public function update($table,$data,$where,$formats=null,$whereFormats=null) { if($table===$this->posts){$id=(int)$where['ID'];foreach($data as $key=>$value)$GLOBALS['safari_posts'][$id]->{$key}=$value;return 1;}return 1; }
}
$GLOBALS['safari_posts']=[];$GLOBALS['safari_meta']=[];$GLOBALS['safari_fields']=[];$GLOBALS['safari_attachment_urls']=[];$GLOBALS['safari_next']=1000;
$GLOBALS['wpdb']=new SafariImageSeedDB();
require_once __DIR__.'/safari-media-stubs.inc';
require_once dirname(__DIR__).'/migration/safari-package-importer.php';
$landing=json_decode(file_get_contents(dirname(__DIR__).'/migration/safari-landing-manifest.json'),true,512,JSON_THROW_ON_ERROR);
$manifest=json_decode(file_get_contents(dirname(__DIR__).'/migration/safari-image-seed-manifest.json'),true,512,JSON_THROW_ON_ERROR);
$assert=static function(bool $ok,string $message):void{if(!$ok)throw new RuntimeException($message);};
$throws=static function(callable $fn,string $message)use($assert):void{try{$fn();}catch(RuntimeException $e){return;}$assert(false,$message);};
ts_safari_validate_image_seed_manifest($manifest,$landing);
$assert(function_exists('ts_safari_image_seed_plan'),'image seed planner is available');
$assert(function_exists('ts_safari_image_seed_apply'),'transactional image seed apply is available');
$destinationIds=['serengeti'=>15,'ngorongoro'=>16,'tarangire'=>17,'kilimanjaro'=>51,'lake-manyara'=>53,'zanzibar'=>61,'ruaha'=>59,'nyerere'=>57,'mahale'=>55];
foreach($destinationIds as $slug=>$id){$GLOBALS['safari_posts'][$id]=(object)['ID'=>$id,'post_type'=>'ts_destination','post_status'=>'publish','post_name'=>$slug,'post_modified'=>'2026-11-12 12:00:00','post_modified_gmt'=>'2026-11-12 09:00:00'];$GLOBALS['safari_fields'][$id]['ts_dest_hero_image']=in_array($slug,['serengeti','ngorongoro','tarangire'],true)?'0':null;$GLOBALS['safari_fields'][$id]['ts_dest_hero_image_url']=$landing['destinations'][array_search($slug,array_column($landing['destinations'],'slug'),true)]['source_image']??$landing['destinations'][array_search($slug,array_column($landing['destinations'],'slug'),true)]['image'];}
$lockedDestination=ts_safari_image_seed_lock_target(15,'ts_destination','serengeti');
$assert((int)$lockedDestination->ID===15&&count(array_filter($GLOBALS['wpdb']->queries,static fn($sql)=>str_contains($sql,'FOR UPDATE')))>=2,'destination lock acquires both the post row and metadata range');

$GLOBALS['safari_posts'][27]=(object)['ID'=>27,'post_type'=>'page','post_status'=>'publish','post_name'=>'safaris','post_title'=>$landing['h1'],'post_content'=>ts_safari_render_landing($landing)];
$GLOBALS['safari_meta'][27]['_ts_safari_landing_managed_hash']=ts_safari_landing_managed_hash(ts_safari_read_landing_page(27));
$baselineManagedHash=ts_safari_landing_managed_hash(ts_safari_read_landing_page(27));
$GLOBALS['safari_meta'][27]['_elementor_page_assets']='a:0:{}';
$GLOBALS['safari_meta'][27]['rank_math_og_content_image']=serialize(['check'=>'derived-cache-checksum','images'=>[$landing['destinations'][0]['image']]]);
$assert(ts_safari_landing_managed_hash(ts_safari_read_landing_page(27))===$baselineManagedHash,'derived Elementor and Rank Math image-cache metadata does not invalidate landing ownership');
$GLOBALS['safari_meta'][27]['_manual_editor_caption']='changed';
$assert(ts_safari_landing_managed_hash(ts_safari_read_landing_page(27))!==$baselineManagedHash,'meaningful editor metadata changes remain visible to landing ownership hashing');
unset($GLOBALS['safari_meta'][27]['_manual_editor_caption']);
$preservation=ts_safari_image_seed_snapshot(ts_safari_read_landing_page(27));
$preserved=json_decode($preservation['json'],true,512,JSON_THROW_ON_ERROR);
$assert(hash('sha256',$preservation['json'])===$preservation['hash']&&($preserved['post']['post_content']??'')===$GLOBALS['safari_posts'][27]->post_content&&isset($preserved['meta_rows'][0]['meta_key']),'image-seed preservation snapshot captures the full current non-Elementor page and raw metadata');
$preservedCacheKeys=array_column(array_values(array_filter($preserved['meta_rows'],static fn($row)=>in_array($row['meta_key'],['_elementor_page_assets','rank_math_og_content_image'],true))),'meta_key');
$assert(($preserved['meta']['_elementor_page_assets'][0]??null)==='a:0:{}'&&($preserved['meta']['rank_math_og_content_image'][0]??null)===$GLOBALS['safari_meta'][27]['rank_math_og_content_image']&&$preservedCacheKeys===['_elementor_page_assets','rank_math_og_content_image'],'full rollback snapshot preserves exact plugin cache metadata even though ownership hashing excludes it');
$actualLandingHash=ts_safari_landing_managed_hash(ts_safari_read_landing_page(27));
$plan=ts_safari_image_seed_plan($manifest,$landing,'');
$assert($actualLandingHash===$baselineManagedHash&&($plan['managed_hash']??'')===$baselineManagedHash,'previously stored landing hash remains valid after Elementor and Rank Math caches are appended');
$assert(($plan['action']??'')==='seed'&&count($plan['assets']??[])===11,'plan identifies all eleven live-page media assets');
$assert(($plan['destinations'][0]['clear_source_url']??false)===true,'plan schedules clearing the nonempty legacy URL field');
$throws(static fn()=>ts_safari_image_seed_plan($manifest,$landing,str_repeat('b',64)),'reject a stale landing managed-state hash during preflight');
$assert(($plan['landing_page']['action']??'')==='seed','plan identifies the landing page images that still need local seeding');
$assert(count(array_filter($plan['assets'],static fn($row)=>($row['action']??'')==='create'))===11,'missing assets are planned for sideload');
$assert(count(array_filter($plan['destinations'],static fn($row)=>($row['action']??'')==='seed'))===9,'all nine empty destination image fields are planned');
$assert($plan['legacy_tours']===[],'no legacy tour records are changed without source-matched live images');
$GLOBALS['safari_fields'][15]['ts_dest_hero_image']='999';
$throws(static fn()=>ts_safari_image_seed_plan($manifest,$landing,str_repeat('a',64)),'refuse an unowned destination image instead of overwriting it');

$asset=ts_safari_image_seed_asset_map($manifest)['landing.hero'];
$before=count($GLOBALS['safari_http_calls']);
$created=ts_safari_image_seed_sideload_asset($asset);
$reused=ts_safari_image_seed_sideload_asset($asset);
$assert(!empty($created['created'])&&empty($reused['created'])&&$created['id']===$reused['id'],'owned image asset is reused idempotently');
$assert(count($GLOBALS['safari_http_calls'])===$before+1,'idempotent media reuse avoids a duplicate HTTP download');
$assert(get_post_meta($created['id'],'_ts_safari_seed_source',true)===$asset['source_url']&&get_post_meta($created['id'],'_ts_safari_seed_owner',true)===$manifest['owner'],'seeded attachment records exact source and owner');
$bad=$asset;$bad['source_url']='https://images.example.invalid/other.jpg';
$throws(static fn()=>ts_safari_image_seed_sideload_asset($bad),'reject an image URL outside the exact manifest allowlist');

$html=ts_safari_render_landing($landing,null,array_fill_keys(array_keys(ts_safari_image_seed_asset_map($manifest)),'https://test.tanzaniasensational.com/wp-content/uploads/seeded.jpg'));
$assert(str_contains($html,'src="https://test.tanzaniasensational.com/wp-content/uploads/seeded.jpg"')&&!str_contains($html,'https://images.unsplash.com/'),'rendered landing uses seeded media URLs instead of remote images');
$assert(str_contains($html,'alt="African safari wilderness — lioness on the Serengeti plains at golden hour"')&&str_contains($html,'alt="Tanzania safari experience — guide and traveler observing wildlife on the savanna"')&&str_contains($html,'alt="Mahale Mountains — Tanzania safari destination with wildlife and landscapes"'),'rendered source image alts exactly match the live site');
$sourceHtml=ts_safari_render_landing($landing);
$assert(ts_safari_image_seed_normalize_landing_content($sourceHtml,$landing,$manifest,[])===$sourceHtml,'source page content remains exact with no image substitutions');
$localUrl='https://test.tanzaniasensational.com/wp-content/uploads/2026/11/landing-hero.jpg';$partialHtml=ts_safari_render_landing($landing,null,['landing.hero'=>$localUrl]);
$assert(ts_safari_image_seed_normalize_landing_content($partialHtml,$landing,$manifest,['landing.hero'=>$localUrl])===$sourceHtml,'normalizer maps an owned local landing image back to its approved source URL');
$unownedHtml=str_replace($localUrl,'https://test.tanzaniasensational.com/wp-content/uploads/unowned.jpg',$partialHtml);
$assert(ts_safari_image_seed_normalize_landing_content($unownedHtml,$landing,$manifest,['landing.hero'=>$localUrl])!==$sourceHtml,'normalizer exposes an unowned local image collision for drift refusal');

echo "PASS: safari image seed plan, owned-media reuse, and local rendering\n";
