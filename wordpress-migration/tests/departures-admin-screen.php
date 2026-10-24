<?php

declare(strict_types=1);

define('ABSPATH', __DIR__);

function __(string $text, string $domain = ''): string { return $text; }
function esc_html__ (string $text, string $domain = ''): string { return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }
function esc_html_e(string $text, string $domain = ''): void { echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }
function esc_html($value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
function esc_attr($value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
function esc_url($value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
function admin_url(string $path = ''): string { return 'https://test.tanzaniasensational.com/wp-admin/' . $path; }
function absint($value): int { return abs((int) $value); }
function wp_unslash($value) { return $value; }
function sanitize_key($value): string { return strtolower(preg_replace('/[^a-z0-9_\\-]/', '', (string) $value)); }
function number_format_i18n(float $number, int $decimals = 0): string { return number_format($number, $decimals, '.', ','); }
function current_user_can(string $capability): bool { return $GLOBALS['test_can_admin'] ?? false; }
function add_menu_page(...$args): void { $GLOBALS['test_admin_menu'] = $args; }
function wp_nonce_field(string $action): void { echo '<input type="hidden" name="_wpnonce" value="nonce-' . esc_attr($action) . '">'; }
function selected($selected, $current = true, bool $echo = true): string
{
    $result = (string) $selected === (string) $current ? ' selected="selected"' : '';
    if ($echo) echo $result;
    return $result;
}
function check_admin_referer(string $action): void
{
    if (($GLOBALS['test_valid_nonces'][$action] ?? false) !== true) {
        wp_die('Invalid nonce.', '', ['response' => 403]);
    }
}
function submit_button(string $text): void { echo '<button type="submit">' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '</button>'; }
function add_query_arg(array $args, string $url): string { return $url . '?' . http_build_query($args); }
function paginate_links(array $args): string
{
    $GLOBALS['test_pagination_args'] = $args;
    return '<ul class="page-numbers"><li><a href="?paged=3">3</a></li></ul>';
}
function wp_die(string $message = '', string $title = '', array $args = []): never
{
    throw new WPDie($message, (int) ($args['response'] ?? 500));
}

final class WPDie extends RuntimeException
{
    public function __construct(string $message, public int $response)
    {
        parent::__construct($message);
    }
}

final class DeparturesAdminTestWpdb
{
    public string $prefix = 'wp_';
    public string $last_results_sql = '';
    public int $get_results_calls = 0;
    public int $count_queries = 0;
    public function get_var(string $sql): int
    {
        ++$this->count_queries;
        return 253;
    }
    public function get_results(string $sql): array
    {
        $this->last_results_sql = $sql;
        ++$this->get_results_calls;
        return [(object) [
            'id' => 42,
            'route_name' => '<script>alert(1)</script>',
            'route_url' => '/trekking/kilimanjaro/lemosho',
            'departure_date' => '2026-11-05',
            'return_date' => '2026-11-13',
            'price_cents' => 289050,
            'currency' => 'USD',
            'total_seats' => 12,
            'booked_seats' => 3,
            'held_seats' => 2,
            'status' => 'limited',
        ]];
    }
    public function prepare(string $sql, ...$args): string
    {
        foreach ($args as $value) {
            $sql = preg_replace('/%d/', (string) (int) $value, $sql, 1);
        }
        return $sql;
    }
    public function get_row(string $sql): ?object { return null; }
}

$class_file = dirname(__DIR__) . '/core-plugin/includes/class-ts-departures-admin.php';
if (!is_file($class_file)) {
    fwrite(STDERR, "FAIL: the protected departure-inventory admin screen does not exist yet.\n");
    exit(1);
}
require $class_file;

$bootstrap = file_get_contents(dirname(__DIR__) . '/core-plugin/tanzania-sensational-core.php');
foreach ([
    "require_once TS_CORE_DIR . 'includes/class-ts-departures-admin.php';",
    "add_action( 'admin_menu', array( 'TS_Departures_Admin', 'register_menu' ) );",
    "add_action( 'admin_post_ts_save_departure', array( 'TS_Departures_Admin', 'save_request' ) );",
    "add_action( 'admin_post_ts_close_departure', array( 'TS_Departures_Admin', 'close_request' ) );",
] as $hook) {
    if (!str_contains($bootstrap, $hook)) {
        throw new RuntimeException('The departures admin screen is not wired to WordPress: ' . $hook);
    }
}

$GLOBALS['wpdb'] = new DeparturesAdminTestWpdb();
TS_Departures_Admin::register_menu();
if ('manage_options' !== $GLOBALS['test_admin_menu'][2] || 'ts-departures' !== $GLOBALS['test_admin_menu'][3]) {
    throw new RuntimeException('The inventory menu must use the administrator capability and its own admin page.');
}

$GLOBALS['test_can_admin'] = false;
try {
    TS_Departures_Admin::render();
    throw new RuntimeException('Unauthorized users must not render departure inventory.');
} catch (WPDie $error) {
    if (403 !== $error->response) throw $error;
}
if (0 !== $GLOBALS['wpdb']->get_results_calls || 0 !== $GLOBALS['wpdb']->count_queries) {
    throw new RuntimeException('Unauthorized users must be rejected before inventory is queried.');
}

$GLOBALS['test_can_admin'] = true;
$_POST = ['departure_id' => '42'];
foreach ([
    ['ts_save_departure', 'save_request'],
    ['ts_close_departure_42', 'close_request'],
] as [$nonce_action, $handler]) {
    $GLOBALS['test_valid_nonces'][$nonce_action] = false;
    try {
        TS_Departures_Admin::$handler();
        throw new RuntimeException('Mutation handlers must reject invalid nonces.');
    } catch (WPDie $error) {
        if (403 !== $error->response) throw $error;
    }
}

$_GET['paged'] = '2';
ob_start();
TS_Departures_Admin::render();
$html = (string) ob_get_clean();
foreach ([
    'Group Departures',
    'name="action" value="ts_save_departure"',
    'nonce-ts_save_departure',
    'name="action" value="ts_close_departure"',
    'nonce-ts_close_departure_42',
    'name="total_seats"',
    'name="inventory_state"',
    '3 booked',
    '2 held',
    '&lt;script&gt;alert(1)&lt;/script&gt;',
] as $expected) {
    if (!str_contains($html, $expected)) {
        throw new RuntimeException('The admin inventory screen is missing safe expected output: ' . $expected);
    }
}
if (!str_contains($html, '<nav aria-label="Departure inventory pages"') || !str_contains($html, '<ul class="page-numbers">')) {
    throw new RuntimeException('Long departure inventory must expose accessible pagination.');
}
if (!str_contains($GLOBALS['wpdb']->last_results_sql, 'LIMIT 50 OFFSET 50') || 2 !== $GLOBALS['test_pagination_args']['current'] || 6 !== $GLOBALS['test_pagination_args']['total']) {
    throw new RuntimeException('Departure inventory pagination must load the requested page with a bounded query.');
}
if (str_contains($html, '<script>alert(1)</script>') || str_contains($html, 'ts_delete_departure')) {
    throw new RuntimeException('Inventory values must be escaped and records must not be deleted from this screen.');
}

echo "PASS: departure admin authorization, create/edit/close actions, capacity context, and output escaping.\n";
