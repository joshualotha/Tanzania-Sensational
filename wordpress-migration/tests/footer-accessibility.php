<?php

// Render the production Elementor widget using the repository's test-double pattern.
namespace Elementor {
    class Controls_Manager { public const TAB_CONTENT = 'content'; public const TEXT = 'text'; public const URL = 'url'; public const REPEATER = 'repeater'; public const SELECT = 'select'; }
    class Repeater {}
    class Widget_Base {
        protected function start_controls_section($id, $args): void {}
        protected function add_control($id, $args): void {}
        protected function end_controls_section(): void {}
        public function get_settings_for_display(): array { return $GLOBALS['footer_settings']; }
    }
}
namespace {
    define('ABSPATH', __DIR__ . '/');
    function __(string $text, string $domain = ''): string { return $text; }
    function esc_html($v): string { return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    function esc_attr($v): string { return esc_html($v); }
    function esc_attr_e(string $v, string $d = ''): void { echo esc_attr($v); }
    function esc_html_e(string $v, string $d = ''): void { echo esc_html($v); }
    function esc_url($v): string { return esc_html($v); }
    function wp_kses_post($v): string { return (string) $v; }
    require __DIR__ . '/../staging-plugin/elementor/widgets/class-ts-footer-widget.php';
    class FooterUnderTest extends \TS_Footer_Widget { public function render_now(): void { $this->render(); } }
    function check(bool $ok, string $why): void { if (!$ok) { fwrite(STDERR, "FAIL: {$why}\n"); exit(1); } }
    function check_email_field(string $html, string $path): void {
        check((bool) preg_match('/<input\b(?=[^>]*type="email")(?=[^>]*aria-label="Email address")[^>]*>/', $html), "{$path} rendered newsletter email field has localized accessible name");
    }
    $GLOBALS['footer_settings'] = ['logo'=>[],'phone'=>'+255-621220912','newsletter_form_action'=>[],'newsletter_eyebrow'=>'Stay Connected','newsletter_title'=>'Stories from the wild','newsletter_subtitle'=>'Updates','tagline'=>'Travel well','email'=>'','address'=>'','columns'=>[],'social_links'=>[],'copyright'=>'Copyright','crafted'=>'Crafted locally'];
    $widget = new FooterUnderTest(); ob_start(); $widget->render_now(); $widget_html = (string) ob_get_clean();
    check_email_field($widget_html, 'Elementor widget');

    // Execute the actual shortcode callback isolated from unrelated plugin bootstrap.
    $src = (string) file_get_contents(__DIR__ . '/../staging-plugin/tanzania-sensational-design.php');
    $needle = "add_shortcode( 'ts_footer', function() {"; $at = strpos($src, $needle);
    check(false !== $at, 'ts_footer shortcode is registered');
    $start = $at + strlen($needle);
        $end = strpos($src, "\n} );", $start);
        check(false !== $end, 'shortcode callback body extracted');
    function ts_get_site_field($key, $default='') { return $default; }
    function plugin_dir_url($file): string { return 'https://example.test/plugin/'; }
    function esc_html__($v,$d=''): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
    function esc_attr__($v,$d=''): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
    function esc_url_raw($v): string { return (string)$v; }
    $callback = eval('return function() {' . substr($src,$start,$end-$start) . "\n};");
    check_email_field((string)$callback(), 'ts_footer shortcode');

    $css=(string)file_get_contents(__DIR__.'/../staging-plugin/public-layout.css');
    check((bool)preg_match('/:where\(([^)]*)\):focus-visible\s*\{([^}]*)\}/s',$css,$m), 'target focus-visible rule exists');
    $selectors=array_map('trim',explode(',',$m[1]));
    foreach(['a','button','input','select','textarea','summary','[role="button"]','[role="link"]','[tabindex]'] as $s) check(in_array($s,$selectors,true), "target rule covers {$s}");
    check((bool)preg_match('/(?:^|;)\s*outline:\s*3px\s+solid\s+#1f5e5b\s*(?:;|$)/i',trim($m[2])), 'target rule uses visible solid outline');
    check((bool)preg_match('/(?:^|;)\s*outline-offset:\s*3px\s*(?:;|$)/i',trim($m[2])), 'target rule offsets outline without layout shift');
    check(!preg_match('/outline:\s*none|inset/i',$m[2]), 'target rule does not suppress native focus or use inset substitute');
    echo "PASS: both rendered footer email fields and scoped keyboard-focus contract.\n";
}
