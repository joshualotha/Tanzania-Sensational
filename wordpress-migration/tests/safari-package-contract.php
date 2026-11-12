<?php
define('ABSPATH', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR);
function wp_parse_url($url) { return parse_url($url); }
function wp_json_encode($value, $flags = 0) { return json_encode($value, $flags); }
function get_permalink($post) { return 'https://test.tanzaniasensational.com/safaris/destinations/'.$post->post_name.'/'; }
function get_posts($args) { $name=$args['name']??''; return array_values(array_filter($GLOBALS['destinationPosts']??[],static fn($p)=>$p->post_type==='ts_destination'&&$p->post_status==='publish'&&$p->post_name===$name)); }
$root = dirname(__DIR__);
require_once $root . '/migration/safari-package-importer.php';
$manifest = json_decode(file_get_contents($root . '/migration/safari-package-import-manifest.json'), true, 512, JSON_THROW_ON_ERROR);
$assert = static function (bool $condition, string $message): void { if (!$condition) throw new RuntimeException($message); };
$throws = static function (callable $fn, string $message) use ($assert): void { try { $fn(); } catch (RuntimeException $e) { return; } $assert(false, $message); };
ts_safari_validate_manifest($manifest);
$assert(array_column($manifest['packages'], 'slug') === ['expected-wildlife-serengeti','ultimate-fly-in-northern-circuit'], 'only the two approved missing package slugs are imported');
$assert($manifest['packages'][0]['price'] === 'From $2,200 per person' && $manifest['packages'][1]['price'] === 'From $2,400 per person', 'starting-price labels remain verbatim strings');
$assert($manifest['packages'][0]['itinerary'][0]['title'] === 'Lake Manyara National Park' && count($manifest['packages'][0]['itinerary']) === 4, 'first package has exactly four source-verified days');
$assert(!in_array('Optional hot air balloon safari ( pp)',$manifest['packages'][0]['exclusions'],true) && in_array('Optional hot air balloon safari',$manifest['packages'][0]['exclusions'],true) && in_array('Optional hot air balloon safari',$manifest['packages'][1]['exclusions'],true), 'malformed missing optional price is omitted without inventing an amount');
$price_fields=ts_safari_expected_fields($manifest['packages'][0]);
$assert($price_fields['ts_tour_price'] === 'From $2,200' && $price_fields['ts_tour_price_note'] === 'per person', 'verbatim source starting-price label composes without duplicate note');
$assert(ts_safari_expected_archive_order($manifest['packages'],[['slug'=>'great-migration-edition','order'=>1],['slug'=>'pioneers-route','order'=>2],['slug'=>'grand-canvas','order'=>3]])===['ultimate-fly-in-northern-circuit','expected-wildlife-serengeti','great-migration-edition','pioneers-route','grand-canvas'], 'five-card archive orders two source packages before preserved legacy posts');
$assert(ts_safari_expected_state($manifest['packages'][1])['post_status'] === 'publish', 'package target state is explicit');
$bad = $manifest; $bad['packages'][0]['slug'] = 'great-migration-edition'; $throws(static fn() => ts_safari_validate_manifest($bad), 'reject legacy slug collision');
$bad = $manifest; $bad['packages'][0]['price'] = 2200; $throws(static fn() => ts_safari_validate_manifest($bad), 'reject numeric price coercion');
$bad = $manifest; $bad['packages'][0]['itinerary'] = []; $throws(static fn() => ts_safari_validate_manifest($bad), 'reject missing source itinerary');
$bad = $manifest; $bad['packages'][0]['source_url'] = 'https://tanzaniasensational.com/booking/safari/x'; $throws(static fn() => ts_safari_validate_manifest($bad), 'reject broken booking/source route as package source');
$assert(ts_safari_validate_run_mode(false, false, false, 'https://test.tanzaniasensational.com/', '0') === true, 'private staging dry-run is allowed');
foreach (['http://test.tanzaniasensational.com/','https://test.tanzaniasensational.com:444/','https://test.tanzaniasensational.com.evil/','https://prod.example/'] as $origin) $throws(static fn() => ts_safari_validate_run_mode(false, false, false, $origin, '0'), 'reject origin ' . $origin);
$throws(static fn() => ts_safari_validate_run_mode(true, true, true, 'https://test.tanzaniasensational.com/', '1'), 'reject public staging');
$route_plan=ts_safari_expected_route_plan();
$assert($route_plan['landing_route'] === '/safaris' && $route_plan['archive_route'] === '/safaris/packages', 'route plan separates landing from packages archive');
$assert($route_plan['source_destination_card_count'] === 9 && $route_plan['expected_published_package_count'] === 5 && $route_plan['source_package_card_count']===2 && $route_plan['route_parity'] === 'apply-required-not-verified' && str_contains($route_plan['landing_action'],'clone') && $route_plan['batch_atomic']===false && $route_plan['external_hook_side_effects_reversed']===false, 'landing clone action, five-card staging acceptance and transaction limits are explicit');
$acf_fixture = [];
foreach (ts_safari_field_schema() as $name => [$type, $subs]) { $acf_fixture['field_'.$name] = ['key'=>'field_'.$name,'name'=>$name,'type'=>$type,'sub_fields'=>array_map(static fn($n,$t)=>['name'=>$n,'type'=>$t],array_keys($subs),array_values($subs))]; }
ts_safari_validate_acf_schema(static fn(string $key) => $acf_fixture[$key] ?? null);
$bad_acf=$acf_fixture; $bad_acf['field_ts_tour_itinerary']['sub_fields']=[];
$throws(static fn()=>ts_safari_validate_acf_schema(static fn(string $key)=>$bad_acf[$key]??null),'reject malformed itinerary ACF repeater');
$page=['ID'=>27,'post_type'=>'page','post_status'=>'publish','post_name'=>'safaris','post_title'=>'Safaris','post_content'=>'','post_excerpt'=>'','meta'=>['_elementor_data'=>'[{"widgetType":"TS_Tour_Archive","settings":{"count":-1,"show_cta":"yes"}}]','_elementor_edit_mode'=>'builder']];
$landing=ts_safari_landing_snapshot($page);ts_safari_guard_landing_snapshot($page,$landing['hash']);
$wrong_widget=$page;$wrong_widget['meta']['_elementor_data']='[{"widgetType":"TS_Tour_Archive","settings":{"count":3,"show_cta":"yes"}}]';
$throws(static fn()=>ts_safari_landing_snapshot($wrong_widget),'require exact reviewed archive widget settings before page replacement');
$changed=$page;$changed['meta']['_elementor_data']='[{"widgetType":"TS_Tour_Archive","settings":{"count":3}}]';
$throws(static fn()=>ts_safari_guard_landing_snapshot($changed,$landing['hash']),'refuse if editor-owned page snapshot changed');
$throws(static fn()=>ts_safari_landing_snapshot(['ID'=>27,'post_type'=>'page','post_name'=>'safaris','meta'=>[]]),'require exact payload before route migration');
$landing_manifest=json_decode(file_get_contents($root.'/migration/safari-landing-manifest.json'),true,512,JSON_THROW_ON_ERROR);
ts_safari_validate_landing_manifest($landing_manifest);
$assert(count($landing_manifest['destinations'])===9 && $landing_manifest['h1']==='Into the Untamed.', 'landing source manifest captures exact identity and all nine source cards');
$destinationPosts=array_map(static fn($card)=>(object)['post_type'=>'ts_destination','post_status'=>'publish','post_name'=>$card['slug']],$landing_manifest['destinations']);$GLOBALS['destinationPosts']=$destinationPosts;
$mapped=ts_safari_resolve_destination_cards($landing_manifest,static fn($slug)=>array_values(array_filter($destinationPosts,static fn($p)=>$p->post_name===$slug)));
$assert(count($mapped)===9 && $mapped[0]['permalink']==='https://test.tanzaniasensational.com/safaris/destinations/serengeti/', 'destination cards resolve to exact existing published post permalinks');
$throws(static fn()=>ts_safari_resolve_destination_cards($landing_manifest,static fn($slug)=>[]),'refuse missing staging destination mapping');
$wrong=$mapped;$wrong[0]['slug']='ngorongoro';$throws(static fn()=>ts_safari_render_landing($landing_manifest,$wrong),'renderer rejects mismatched destination slug identity');
$wrong=$mapped;$wrong[0]['title']='Unverified destination title';$throws(static fn()=>ts_safari_render_landing($landing_manifest,$wrong),'renderer rejects mismatched source destination content');
$wrong=$mapped;$wrong[0]['permalink']=get_permalink($destinationPosts[1]);$throws(static fn()=>ts_safari_render_landing($landing_manifest,$wrong),'renderer rejects a valid staging URL mapped to the wrong published destination');
$wrong=$mapped;[$wrong[0],$wrong[1]]=[$wrong[1],$wrong[0]];$throws(static fn()=>ts_safari_render_landing($landing_manifest,$wrong),'renderer rejects destination cards outside the approved source order');
$resolved=$mapped;
$landing_html=ts_safari_render_landing($landing_manifest,$resolved);
$assert(substr_count($landing_html,'class="premium-dest-card"')===9 && str_contains($landing_html,'Into the Untamed.'), 'landing renderer emits nine destination cards and source H1');
$assert(!str_contains($landing_html,'href="/safaris/packages"') && !str_contains($landing_html,'Featured Packages'), 'landing body does not invent a package CTA absent from source');
foreach (['NATIONAL PARKS','GUIDED EXPEDITIONS','BOUTIQUE CAMPS','SPECIES CATALOGED','The Legacy','Watching the Serengeti sunrise from our balloon, followed by a champagne breakfast seamlessly prepared in the bush, felt like a dream.','SARAH &amp; JAMES W. • LONDON, UK','The Difference','Experience That Speaks.','Architected Itineraries','Locally Born Mastery','INITIALIZE YOUR JOURNEY'] as $sourceText) $assert(str_contains($landing_html,$sourceText), 'landing preserves verified section: '.$sourceText);
$assert(str_contains($landing_html,'href="https://test.tanzaniasensational.com/safaris/destinations/serengeti/"'), 'landing uses resolved existing staging destination permalink');
$assert(str_contains($landing_html,'https://tanzaniasensational.com/storage/destinations/'), 'landing uses verified absolute destination image URL');
$assert($landing_manifest['hero_image']==='https://images.unsplash.com/photo-1516426122078-c23e76319801?w=2000&q=85&auto=format&fit=crop', 'landing uses verified source hero image');
$style=file_get_contents($root.'/staging-plugin/safari-landing.css');$design=file_get_contents($root.'/staging-plugin/tanzania-sensational-design.php');
$assert(is_string($style)&&str_contains($style,'@media (max-width: 640px)')&&str_contains($style,'object-fit: cover'), 'landing style includes responsive media and cropped image treatment');
$assert(str_contains($design,"is_page( 'safaris' )")&&str_contains($design,"'safari-landing.css'"), 'landing stylesheet is enqueued on the target WordPress route');

$bad_landing=$landing_manifest;$bad_landing['metrics'][0]['value']='8';$throws(static fn()=>ts_safari_validate_landing_manifest($bad_landing),'refuse unverified source counter values');
$assert(!isset($landing_manifest['package_cta']) && $landing_manifest['journey_cta']['url']==='/contact', 'landing manifest omits package CTA and preserves contact CTA');
$throws(static fn()=>ts_safari_validate_landing_manifest(array_merge($landing_manifest,['destinations'=>[]])),'reject incomplete source landing cards');
 echo "PASS: safari package migration contracts\n";
