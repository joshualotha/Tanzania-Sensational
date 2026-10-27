<?php
require_once dirname(__DIR__) . '/migration/trekking-importer.php';
$expected = ['post_type'=>'ts_trek_route','post_status'=>'publish','post_name'=>'a','post_title'=>'A','post_content'=>'','fields'=>[]];
$other = $expected; $other['post_title'] = 'B';
try { ts_trek_assert_snapshot_matches_expected($expected, $other); } catch (RuntimeException $e) { echo "PASS: saved snapshot mismatch rejected\n"; exit(0); }
throw new RuntimeException('Expected source-manifest snapshot mismatch to be rejected');
