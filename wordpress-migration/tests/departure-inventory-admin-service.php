<?php

declare(strict_types=1);

define('ABSPATH', __DIR__);

function __(string $text, string $domain = ''): string
{
    return $text;
}

function current_time(string $format, bool $gmt = false): string
{
    return '2026-10-24 12:00:00';
}

function sanitize_text_field($value): string
{
    return trim(strip_tags((string) $value));
}

function absint($value): int
{
    return abs((int) $value);
}

function home_url(string $path = '/'): string
{
    return 'https://test.tanzaniasensational.com' . $path;
}

function wp_parse_url(string $url, int $component = -1)
{
    return parse_url($url, $component);
}

function esc_url_raw(string $url): string
{
    return filter_var($url, FILTER_SANITIZE_URL);
}

function sanitize_key($key): string
{
    return strtolower(preg_replace('/[^a-z0-9_\\-]/', '', (string) $key));
}

function is_wp_error($value): bool
{
    return $value instanceof WP_Error;
}

final class WP_Error
{
    public function __construct(public string $code, public string $message = '', public array $data = [])
    {
    }

    public function get_error_code(): string
    {
        return $this->code;
    }
}

final class InventoryTestWpdb
{
    public string $prefix = 'wp_';
    public int $insert_id = 51;
    public array $queries = [];
    public array $writes = [];
    public ?object $departure;
    public ?string $fail_query = null;
    public ?string $fail_update_table = null;

    public function __construct(?object $departure = null)
    {
        $this->departure = $departure;
    }

    public function prepare(string $sql, ...$args): string
    {
        return preg_replace_callback('/%[sd]/', static function (array $match) use (&$args): string {
            $value = array_shift($args);
            return '%d' === $match[0] ? (string) (int) $value : "'" . addslashes((string) $value) . "'";
        }, $sql);
    }

    public function query(string $sql): bool
    {
        $this->queries[] = $sql;
        return $sql !== $this->fail_query;
    }

    public function get_row(string $sql): ?object
    {
        $this->queries[] = $sql;
        if (str_contains($sql, 'WHERE id = 51')) {
            return (object) array_merge(['id' => 51, 'booked_seats' => 0, 'held_seats' => 0], $this->writes['insert'] ?? []);
        }
        return $this->departure;
    }

    public function insert(string $table, array $data): int|false
    {
        $this->writes['insert'] = $data;
        return 1;
    }

    public function update(string $table, array $data, array $where): int|false
    {
        $this->writes['update'] = ['table' => $table, 'data' => $data, 'where' => $where];
        if ($table === $this->fail_update_table) {
            return false;
        }
        return 1;
    }
}

$service = dirname(__DIR__) . '/core-plugin/includes/class-ts-departure-inventory.php';
if (!is_file($service)) {
    fwrite(STDERR, "FAIL: departure inventory service does not exist yet.\n");
    exit(1);
}
require $service;

function inventory_input(array $overrides = []): array
{
    return array_merge([
        'route_name' => 'Lemosho 8-day route',
        'route_url' => '/trekking/kilimanjaro/lemosho-8-days',
        'departure_date' => '2026-11-05',
        'return_date' => '2026-11-13',
        'price' => '2890.50',
        'currency' => 'USD',
        'total_seats' => '12',
        'inventory_state' => 'open',
    ], $overrides);
}

function assert_inventory(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$wpdb = new InventoryTestWpdb();
$GLOBALS['wpdb'] = $wpdb;
$created = TS_Departure_Inventory::save(0, inventory_input());
assert_inventory(!is_wp_error($created), 'A valid departure should be created.');
assert_inventory(289050 === $wpdb->writes['insert']['price_cents'], 'Decimal price must be stored as exact cents.');
assert_inventory(12 === $wpdb->writes['insert']['total_seats'], 'Seat capacity must be normalized to an integer.');
assert_inventory('available' === $wpdb->writes['insert']['status'], 'Open inventory should derive availability from capacity.');
assert_inventory(in_array('COMMIT', $wpdb->queries, true), 'Successful create should commit.');

$wpdb = new InventoryTestWpdb((object) [
    'id' => 8,
    'booked_seats' => 3,
    'held_seats' => 2,
    'total_seats' => 12,
]);
$GLOBALS['wpdb'] = $wpdb;
$too_small = TS_Departure_Inventory::save(8, inventory_input(['total_seats' => '4']));
assert_inventory(is_wp_error($too_small) && 'ts_capacity_below_reservations' === $too_small->get_error_code(), 'Capacity cannot be reduced below booked plus held seats.');
assert_inventory(!isset($wpdb->writes['update']) && in_array('ROLLBACK', $wpdb->queries, true), 'An unsafe capacity edit must not write and must roll back.');

$wpdb = new InventoryTestWpdb((object) [
    'id' => 8,
    'booked_seats' => 3,
    'held_seats' => 2,
    'total_seats' => 12,
]);
$GLOBALS['wpdb'] = $wpdb;
$updated = TS_Departure_Inventory::save(8, inventory_input(['total_seats' => '8', 'price' => '8', 'inventory_state' => 'closed']));
assert_inventory(!is_wp_error($updated), 'A safe edit and close should succeed.');
assert_inventory('closed' === $wpdb->writes['update']['data']['status'], 'Closed inventory must remain closed.');
assert_inventory(800 === $wpdb->writes['update']['data']['price_cents'], 'Updated decimal price must be stored exactly in cents.');
assert_inventory(in_array('COMMIT', $wpdb->queries, true), 'Successful update should commit.');

$wpdb = new InventoryTestWpdb((object) [
    'id' => 8,
    'booked_seats' => 3,
    'held_seats' => 2,
    'total_seats' => 12,
    'status' => 'limited',
]);
$GLOBALS['wpdb'] = $wpdb;
$closed = TS_Departure_Inventory::close(8);
assert_inventory(!is_wp_error($closed), 'A departure should be closable without deleting it.');
assert_inventory('closed' === $wpdb->writes['update']['data']['status'], 'Close must only change inventory availability.');
assert_inventory(!isset($wpdb->writes['update']['data']['booked_seats']) && !isset($wpdb->writes['update']['data']['held_seats']), 'Closing must preserve booking and hold counters.');
assert_inventory(in_array('COMMIT', $wpdb->queries, true), 'Successful close should commit.');

foreach ([
    ['departure_date' => '2026-02-30'],
    ['return_date' => '2026-11-01'],
    ['price' => '-1'],
    ['currency' => 'US'],
    ['inventory_state' => 'booked'],
    ['route_url' => 'https://attacker.example/path'],
    ['route_url' => '//attacker.example/path'],
    ['route_url' => str_repeat('a', 501)],
] as $invalid) {
    $wpdb = new InventoryTestWpdb();
    $GLOBALS['wpdb'] = $wpdb;
    $result = TS_Departure_Inventory::save(0, inventory_input($invalid));
    assert_inventory(is_wp_error($result), 'Invalid departure data must be rejected: ' . json_encode($invalid));
    assert_inventory(!$wpdb->writes && !$wpdb->queries, 'Invalid departure data must fail before database writes.');
}

$wpdb = new InventoryTestWpdb();
$wpdb->fail_query = 'START TRANSACTION';
$GLOBALS['wpdb'] = $wpdb;
$start_failed = TS_Departure_Inventory::save(0, inventory_input());
assert_inventory(is_wp_error($start_failed), 'A failed transaction start must not report a departure as saved.');
assert_inventory(!isset($wpdb->writes['insert']) && !in_array('COMMIT', $wpdb->queries, true), 'No inventory writes may occur when the transaction cannot start.');

$wpdb = new InventoryTestWpdb();
$wpdb->fail_query = 'COMMIT';
$GLOBALS['wpdb'] = $wpdb;
$commit_failed = TS_Departure_Inventory::save(0, inventory_input());
assert_inventory(is_wp_error($commit_failed), 'A failed transaction commit must not report a departure as saved.');
assert_inventory(in_array('ROLLBACK', $wpdb->queries, true), 'A failed inventory commit must attempt rollback.');

echo "PASS: departure inventory create/edit validation, capacity protection, and transaction failure handling.\n";
