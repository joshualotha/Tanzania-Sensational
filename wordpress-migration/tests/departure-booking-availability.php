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
    return 'mysql' === $format ? '2026-10-24 12:00:00' : '2026-10-24';
}

function wp_generate_password(int $length): string
{
    return str_repeat('A', $length);
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

final class TestWpdb
{
    public string $prefix = 'wp_';
    public bool $insert_called = false;
    public bool $update_called = false;
    public int $insert_id = 90;
    public int $get_row_calls = 0;
    public array $insert_data = [];
    public array $queries = [];

    public function __construct(public object $departure, private bool $insert_result = false)
    {
    }

    public function query(string $sql): bool
    {
        $this->queries[] = $sql;
        return true;
    }

    public function prepare(string $sql, ...$args): string
    {
        return preg_replace_callback('/%[sd]/', static function (array $match) use (&$args): string {
            $value = array_shift($args);
            return $match[0] === '%d' ? (string) (int) $value : "'" . addslashes((string) $value) . "'";
        }, $sql);
    }

    public function get_row(string $sql): object
    {
        ++$this->get_row_calls;
        if (1 === $this->get_row_calls) {
            return $this->departure;
        }

        return (object) [
            'id' => $this->insert_id,
            'booking_ref' => 'TS-' . str_repeat('A', 8),
            'status' => 'new',
            'held_seats' => 0,
        ];
    }

    public function insert(string $table, array $data): bool
    {
        $this->insert_called = true;
        $this->insert_data = $data;
        return $this->insert_result;
    }

    public function update(string $table, array $data, array $where): int
    {
        $this->update_called = true;
        return 1;
    }
}

require dirname(__DIR__) . '/core-plugin/includes/class-ts-booking-workflow.php';

function booking_request(int $group_size): array
{
    return [
        'departure_id' => 5,
        'customer_name' => 'Test Guest',
        'email' => 'test@example.invalid',
        'phone' => '',
        'country' => '',
        'group_size' => $group_size,
        'special_requests' => '',
    ];
}

function assert_unavailable_departure_is_rejected(string $date, string $status): void
{
    $departure = (object) [
        'id' => 5,
        'departure_date' => $date,
        'status' => $status,
        'total_seats' => 12,
        'booked_seats' => 0,
        'held_seats' => 0,
        'price_cents' => 200000,
        'currency' => 'USD',
    ];
    $wpdb = new TestWpdb($departure);
    $GLOBALS['wpdb'] = $wpdb;
    $result = TS_Booking_Workflow::create_departure_booking(booking_request(1));

    if (!$result instanceof WP_Error || 'ts_departure_unavailable' !== $result->get_error_code()) {
        throw new RuntimeException("Expected unavailable {$status} departure dated {$date} to be rejected.");
    }
    if ($wpdb->insert_called || !in_array('ROLLBACK', $wpdb->queries, true)) {
        throw new RuntimeException('Unavailable departure must not create a booking and must roll back its transaction.');
    }
}

function assert_insufficient_capacity_is_rejected(): void
{
    $departure = (object) [
        'id' => 5,
        'departure_date' => '2026-11-05',
        'status' => 'limited',
        'total_seats' => 3,
        'booked_seats' => 1,
        'held_seats' => 1,
        'price_cents' => 200000,
        'currency' => 'USD',
    ];
    $wpdb = new TestWpdb($departure);
    $GLOBALS['wpdb'] = $wpdb;
    $result = TS_Booking_Workflow::create_departure_booking(booking_request(2));

    if (!$result instanceof WP_Error || 'ts_insufficient_seats' !== $result->get_error_code()) {
        throw new RuntimeException('Expected a request larger than remaining capacity to be rejected.');
    }
    if ($wpdb->insert_called || !in_array('ROLLBACK', $wpdb->queries, true)) {
        throw new RuntimeException('Insufficient-capacity requests must not persist and must roll back.');
    }
}

function assert_invalid_group_sizes_are_rejected(): void
{
    $departure = (object) [
        'id' => 5,
        'departure_date' => '2026-11-05',
        'status' => 'available',
        'total_seats' => 12,
        'booked_seats' => 0,
        'held_seats' => 0,
        'price_cents' => 200000,
        'currency' => 'USD',
    ];

    foreach ([0, -1, 21, '1.5', null] as $groupSize) {
        $wpdb = new TestWpdb($departure);
        $GLOBALS['wpdb'] = $wpdb;
        $request = booking_request(1);
        $request['group_size'] = $groupSize;
        $result = TS_Booking_Workflow::create_departure_booking($request);

        if (!$result instanceof WP_Error || 'ts_invalid_group_size' !== $result->get_error_code()) {
            throw new RuntimeException('Expected invalid group size to be rejected: ' . var_export($groupSize, true));
        }
        if ($wpdb->insert_called || $wpdb->update_called || $wpdb->queries) {
            throw new RuntimeException('Invalid group size must be rejected before transaction or database writes.');
        }
    }
}

function assert_valid_departure_booking_succeeds(): void
{
    $departure = (object) [
        'id' => 5,
        'departure_date' => '2026-10-24',
        'status' => 'available',
        'total_seats' => 12,
        'booked_seats' => 0,
        'held_seats' => 0,
        'price_cents' => 200000,
        'currency' => 'USD',
    ];
    $wpdb = new TestWpdb($departure, true);
    $GLOBALS['wpdb'] = $wpdb;
    $result = TS_Booking_Workflow::create_departure_booking(booking_request(2));

    if ($result instanceof WP_Error || 'TS-' . str_repeat('A', 8) !== $result->booking_ref) {
        throw new RuntimeException('Expected an available departure dated today to accept a valid request.');
    }
    if (!$wpdb->insert_called || !$wpdb->update_called || 2 !== $wpdb->insert_data['held_seats'] || !in_array('COMMIT', $wpdb->queries, true)) {
        throw new RuntimeException('Valid requests must persist, hold the requested seats, and commit.');
    }
}

assert_unavailable_departure_is_rejected('2026-11-05', 'closed');
assert_unavailable_departure_is_rejected('2026-10-23', 'available');
assert_insufficient_capacity_is_rejected();
assert_invalid_group_sizes_are_rejected();
assert_valid_departure_booking_succeeds();

echo "PASS: booking guards reject closed, past, insufficient-capacity, and invalid group-size requests and accept valid inventory.\n";
