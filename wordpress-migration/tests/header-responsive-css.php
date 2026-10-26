<?php
$css = file_get_contents( __DIR__ . '/../staging-plugin/public-layout.css' );
if ( false === $css ) {
    fwrite( STDERR, "FAIL: could not read public-layout.css.\n" );
    exit( 1 );
}

$plugin = file_get_contents( __DIR__ . '/../staging-plugin/tanzania-sensational-design.php' );
if ( false === $plugin || false === strpos( $plugin, "filemtime( __DIR__ . '/public-layout.css' )" ) ) {
    fwrite( STDERR, "FAIL: public-layout.css must use a file-based cache version.\n" );
    exit( 1 );
}

$desktop_rule = strrpos( $css, ".topbar-left {\n  display: flex;" );
$mobile_rule  = strrpos( $css, '.topbar-left { display: none; }' );
$mobile_media = false === $mobile_rule ? false : strrpos( substr( $css, 0, $mobile_rule ), '@media (max-width: 900px)' );
$mobile_block = false === $mobile_media ? '' : substr( $css, $mobile_media );
$required     = array(
    '.topbar {',
    'padding: 0 16px;',
    'justify-content: flex-end;',
    '.topbar-right { flex: 1 1 auto; justify-content: flex-end; }',
    '.topbar-cta { white-space: nowrap; }',
);

if ( false === $desktop_rule || false === $mobile_rule || $mobile_rule <= $desktop_rule ) {
    fwrite( STDERR, "FAIL: mobile topbar overrides must appear after desktop topbar rules.\n" );
    exit( 1 );
}

foreach ( $required as $declaration ) {
    if ( false === strpos( $mobile_block, $declaration ) ) {
        fwrite( STDERR, "FAIL: mobile topbar override is missing: {$declaration}\n" );
        exit( 1 );
    }
}

fwrite( STDOUT, "PASS: mobile topbar overrides follow desktop rules.\n" );
