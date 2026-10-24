<?php

declare(strict_types=1);

namespace Elementor {
    class Widget_Base
    {
        public array $test_settings = [];

        public function get_settings_for_display(): array
        {
            return $this->test_settings;
        }
    }
}

namespace {
    define('ABSPATH', __DIR__);

    function esc_html($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    function esc_url($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    function home_url(string $path): string
    {
        return 'https://test.tanzaniasensational.com' . $path;
    }

    function date_i18n(string $format, int $timestamp): string
    {
        return date($format, $timestamp);
    }

    function number_format_i18n(float $number, int $decimals = 0): string
    {
        return number_format($number, $decimals, '.', ',');
    }

    function _n(string $single, string $plural, int $number, string $domain = ''): string
    {
        return 1 === $number ? $single : $plural;
    }

    function __(string $text, string $domain = ''): string
    {
        return $text;
    }

    function absint($value): int
    {
        return abs((int) $value);
    }

    function sanitize_text_field($value): string
    {
        return trim(strip_tags((string) $value));
    }

    final class TS_Departures_Public
    {
        public static array $fixtures = [];
        public static $requested_limit = null;

        public static function get_available_departures($limit = 0): array
        {
            self::$requested_limit = $limit;
            return self::$fixtures;
        }
    }

    require dirname(__DIR__) . '/staging-plugin/elementor/widgets/class-ts-departures-widget.php';

    final class TestDeparturesWidget extends TS_Departures_Widget
    {
        public function render_output(): string
        {
            ob_start();
            $this->render();
            return (string) ob_get_clean();
        }

        public function preview_output(): string
        {
            ob_start();
            $this->content_template();
            return (string) ob_get_clean();
        }
    }

    TS_Departures_Public::$fixtures = [
        (object) [
            'id' => 42,
            'route_name' => 'Lemosho Route',
            'departure_date' => '2026-11-05',
            'total_seats' => 12,
            'booked_seats' => 4,
            'held_seats' => 2,
            'price_cents' => 289000,
            'currency' => 'USD',
        ],
        (object) [
            'id' => 43,
            'route_name' => '<script>alert(1)</script>',
            'departure_date' => '2026-11-12',
            'total_seats' => 6,
            'booked_seats' => 1,
            'held_seats' => 1,
            'price_cents' => 123400,
            'currency' => 'EUR',
        ],
    ];

    $widget = new TestDeparturesWidget();
    $widget->test_settings = [
        'eyebrow' => 'Join a Team',
        'title' => "Group\nDepartures",
        'description' => 'Current group inventory',
        'button_text' => 'View All Dates',
        'button_url' => ['url' => '/group-departures/'],
        'max_departures' => 4,
        'empty_message' => 'No upcoming dates.',
        'departures' => [
            ['route_name' => 'STALE EDITOR DEFAULT', 'date' => 'Oct 15', 'spots' => 5, 'price' => 2890],
        ],
    ];

    $html = $widget->render_output();
    $expectedLink = 'https://test.tanzaniasensational.com/group-departures/?departure_id=42';
    $additionalExpectations = [
        'href="https://test.tanzaniasensational.com/group-departures/?departure_id=42"',
        'Nov 12',
        '4 spots left',
        'From EUR 1,234',
        '&lt;script&gt;alert(1)&lt;/script&gt;',
        'href="https://test.tanzaniasensational.com/group-departures/?departure_id=43"',
    ];
    foreach (array_merge(['Lemosho Route', 'Nov 5', '6 spots left', 'From $2,890', $expectedLink], $additionalExpectations) as $expected) {
        if (!str_contains($html, $expected)) {
            throw new RuntimeException('Expected dynamic departure output to contain: ' . $expected);
        }
    }
    if (str_contains($html, 'STALE EDITOR DEFAULT') || str_contains($html, '<script>alert(1)</script>') || 4 !== (int) TS_Departures_Public::$requested_limit) {
        throw new RuntimeException('Homepage cards must come from the shared availability inventory, not saved repeater defaults.');
    }
    $preview = $widget->preview_output();
    if (!str_contains($preview, 'departure-card-v3') || !str_contains($preview, 'aria-hidden="true"') || !str_contains($preview, 'Layout preview only — live departure details appear on the published page.')) {
        throw new RuntimeException('Elementor preview should show an accessible layout-only placeholder without implying live inventory.');
    }

    echo "PASS: homepage departure cards render live inventory and link to the selected booking form.\n";
}
