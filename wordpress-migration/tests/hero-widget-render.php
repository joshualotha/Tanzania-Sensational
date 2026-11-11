<?php

declare(strict_types=1);

namespace Elementor {
    final class Controls_Manager
    {
        public const TAB_CONTENT = 'content';
        public const MEDIA = 'media';
        public const TEXTAREA = 'textarea';
        public const TEXT = 'text';
        public const URL = 'url';
        public const SWITCHER = 'switcher';
    }

    class Widget_Base
    {
        protected array $test_controls = [];

        protected function start_controls_section(string $id, array $args): void {}
        protected function add_control(string $id, array $args): void { $this->test_controls[$id] = $args; }
        protected function end_controls_section(): void {}

        public function get_settings_for_display(): array
        {
            return $GLOBALS['ts_hero_test_settings'] ?? [];
        }

    }
}

namespace {
    if (!defined('ABSPATH')) {
        define('ABSPATH', __DIR__ . '/');
    }

    function __(string $text, string $domain = ''): string { return $text; }
    function esc_html($value): string { return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    function esc_attr($value): string { return esc_html($value); }
    function esc_url($value): string { return esc_html($value); }
    function esc_html_e(string $text, string $domain = ''): void { echo esc_html($text); }
    function wp_strip_all_tags($value): string { return strip_tags((string) $value); }
    function plugins_url(string $path = '', string $plugin = ''): string
    {
        return 'https://test.tanzaniasensational.com/wp-content/plugins/tanzania-sensational-design/' . ltrim($path, '/');
    }

    require __DIR__ . '/../staging-plugin/elementor/widgets/class-ts-hero-widget.php';

    final class Testable_TS_Hero_Widget extends \TS_Hero_Widget
    {
        public function controls_for_test(): array
        {
            $this->register_controls();
            return $this->test_controls;
        }
        public function render_for_test(): void { $this->render(); }
        public function content_template_for_test(): void { $this->content_template(); }
    }

    function ts_hero_assert(bool $condition, string $message): void
    {
        if (!$condition) {
            throw new RuntimeException($message);
        }
    }

    $widget = new Testable_TS_Hero_Widget();
    $controls = $widget->controls_for_test();
    $hero_url = (string) ($controls['background_image']['default']['url'] ?? '');
    ts_hero_assert(
        str_contains($hero_url, '/assets/images/home-hero.webp'),
        'The editable hero image should default to the bundled source-matched photo.'
    );
    ts_hero_assert(
        is_file(__DIR__ . '/../staging-plugin/assets/images/home-hero.webp'),
        'The bundled source-matched hero image should exist in the design plugin.'
    );

    $GLOBALS['ts_hero_test_settings'] = [
        'background_image' => ['url' => 'https://test.tanzaniasensational.com/example-hero.jpg'],
        'title' => "Into the Wild.\nBeyond the Ordinary.",
        'subtitle' => 'A source-matched safari introduction.',
        'primary_button_text' => 'Explore Safaris',
        'primary_button_url' => ['url' => '/safaris'],
        'secondary_button_text' => 'Climb Kilimanjaro',
        'secondary_button_url' => ['url' => '/kilimanjaro-pillar'],
        'show_scroll_indicator' => 'yes',
    ];

    ob_start();
    $widget->render_for_test();
    $html = (string) ob_get_clean();
    ts_hero_assert(
        (bool) preg_match('/<h1 class="hero-v2-title">\s*Into the Wild\.\s*<em>Beyond the Ordinary\.<\/em>\s*<\/h1>/s', $html),
        'The second title line should retain the source design’s italic gold emphasis.'
    );
    ts_hero_assert(str_contains($html, 'alt="Into the Wild. Beyond the Ordinary."'), 'The hero image alt text should remain meaningful.');

    $homepage_css = (string) file_get_contents(__DIR__ . '/../staging-plugin/homepage.css');
    ts_hero_assert(
        (bool) preg_match('/\.hero-v2-bg\s*>\s*img\.hero-v2-bg-img\s*\{[^}]*height:\s*100%;/s', $homepage_css),
        'The hero background image must fill its container despite global Elementor image sizing.'
    );
    $plugin_bootstrap = (string) file_get_contents(__DIR__ . '/../staging-plugin/tanzania-sensational-design.php');
    ts_hero_assert(
        str_contains($plugin_bootstrap, "ts_design_asset_version( __DIR__ . '/homepage.css', '1.2.1' )"),
        'Homepage CSS cache version must change when the stylesheet changes.'
    );

    $GLOBALS['ts_hero_test_settings']['title'] = "Explore.\n<img src=x onerror=alert(2)>";
    $GLOBALS['ts_hero_test_settings']['subtitle'] = '<img src=x onerror=alert(2)>';
    $GLOBALS['ts_hero_test_settings']['primary_button_text'] = '<img src=x onerror=alert(2)>';
    $GLOBALS['ts_hero_test_settings']['secondary_button_text'] = '<img src=x onerror=alert(2)>';
    ob_start();
    $widget->render_for_test();
    $escaped_html = (string) ob_get_clean();
    ts_hero_assert(!str_contains($escaped_html, '<img src=x onerror=alert(2)>'), 'Editor-entered hero text must not render as markup.');
    ts_hero_assert(substr_count($escaped_html, '&lt;img src=x onerror=alert(2)&gt;') === 5, 'Title, image alt, subtitle, and button labels should all be escaped.');

    ob_start();
    $widget->content_template_for_test();
    $template = (string) ob_get_clean();
    ts_hero_assert(str_contains($template, '{{ titleFirst }}'), 'Elementor preview must escape the first title line.');
    ts_hero_assert(str_contains($template, '{{ titleAccent }}'), 'Elementor preview must escape the emphasized title line.');
    ts_hero_assert(str_contains($template, '{{ titleAlt }}'), 'Elementor preview image should have meaningful alt text.');
    ts_hero_assert(str_contains($template, '{{ settings.subtitle }}'), 'Elementor preview must escape subtitle text.');
    ts_hero_assert(str_contains($template, '{{ settings.primary_button_text }}'), 'Elementor preview must escape the primary label.');
    ts_hero_assert(str_contains($template, '{{ settings.secondary_button_text }}'), 'Elementor preview must escape the secondary label.');
    ts_hero_assert(
        str_contains($template, 'var tsSafeHeroUrl = function'),
        'Elementor preview must validate link schemes before placing a user URL in href.'
    );
    ts_hero_assert(
        str_contains($template, 'href="{{ tsSafeHeroUrl(settings.primary_button_url.url) }}"') &&
        str_contains($template, 'href="{{ tsSafeHeroUrl(settings.secondary_button_url.url) }}"'),
        'Both preview CTA links must use the URL-scheme validator and HTML attribute escaping.'
    );
    ts_hero_assert(!str_contains($template, 'href="{{ settings.primary_button_url.url }}"'), 'Primary preview URL must not be interpolated without scheme validation.');
    ts_hero_assert(!str_contains($template, 'href="{{ settings.secondary_button_url.url }}"'), 'Secondary preview URL must not be interpolated without scheme validation.');
    ts_hero_assert(!str_contains($template, '{{{ settings.'), 'Elementor preview must not render widget settings as raw HTML.');
    ts_hero_assert(!str_contains($template, '{{{ title }}}'), 'Elementor preview must not interpolate the title as raw HTML.');

    fwrite(STDOUT, "PASS: hero widget preserves title emphasis, uses the bundled source image, and escapes editor text.\n");
}
