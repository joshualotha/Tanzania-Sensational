<?php

declare(strict_types=1);

define('ABSPATH', __DIR__);
define('HOUR_IN_SECONDS', 3600);

function __(string $text, string $domain = ''): string
{
    return $text;
}

function current_time(string $format, bool $gmt = false): string
{
    return '2026-10-24 12:00:00';
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
}

final class ClosedDepartureTestWpdb
{
    public string $prefix = 'wp_';
    public array $updates = [];
    public array $queries = [];
    public int $insert_count = 0;
    public int $insert_id = 0;

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
        return true;
    }

    public function get_row(string $sql): object
    {
        if (str_contains($sql, 'wp_ts_bookings')) {
            return (object) [
                'id' => 901,
                'booking_type' => 'departure',
                'departure_id' => 5,
                'status' => 'new',
                'held_seats' => 1,
                'group_size' => 1,
            ];
        }
        return (object) [
            'id' => 5,
            'status' => 'closed',
            'total_seats' => 12,
            'booked_seats' => 2,
            'held_seats' => 1,
        ];
    }

    public function insert(string $table, array $data): int
    {
        ++$this->insert_count;
        $this->insert_id = 902;
        return 1;
    }

    public function update(string $table, array $data, array $where): int
    {
        $this->updates[] = compact('table', 'data', 'where');
        return 1;
    }
}

require dirname(__DIR__) . '/core-plugin/includes/class-ts-booking-workflow.php';

$wpdb = new ClosedDepartureTestWpdb();
$GLOBALS['wpdb'] = $wpdb;
$result = TS_Booking_Workflow::create_departure_booking([
    'departure_id' => 5,
    'customer_name' => 'Synthetic test',
    'email' => 'qa@example.invalid',
    'phone' => '',
    'country' => 'QA',
    'group_size' => 1,
    'special_requests' => 'Closed-departure regression test.',
]);
if (!is_wp_error($result) || 'ts_departure_unavailable' !== $result->code) {
    throw new RuntimeException('A closed departure must reject new booking holds.');
}
if (0 !== $wpdb->insert_count || [] !== $wpdb->updates) {
    throw new RuntimeException('A rejected booking must not insert a hold or alter closed inventory.');
}

$wpdb = new ClosedDepartureTestWpdb();
$GLOBALS['wpdb'] = $wpdb;
$result = TS_Booking_Workflow::transition_status(901, 'cancelled');
if (is_wp_error($result)) {
    throw new RuntimeException('Expected the held booking to be cancelled.');
}
$departure_write = array_values(array_filter($wpdb->updates, static fn (array $write): bool => str_ends_with($write['table'], 'ts_departures')))[0] ?? null;
if (!$departure_write || 'closed' !== $departure_write['data']['status']) {
    throw new RuntimeException('Reconciliation must not reopen an inventory item that operations closed.');
}

 echo "PASS: closed departures reject new holds and booking reconciliation preserves operations-closed status.\n";
