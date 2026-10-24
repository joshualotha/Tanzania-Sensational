<?php

declare(strict_types=1);

define('ABSPATH', __DIR__);
define('HOUR_IN_SECONDS', 3600);

function __(string $text, string $domain = ''): string { return $text; }
function current_time(string $format, bool $gmt = false): string { return 'mysql' === $format ? '2026-10-24 12:00:00' : '2026-10-24'; }
function sanitize_key($value): string { return strtolower(preg_replace('/[^a-z0-9_\\-]/', '', (string) $value)); }
function is_wp_error($value): bool { return $value instanceof WP_Error; }

final class WP_Error
{
    public function __construct(public string $code, public string $message = '', public array $data = []) {}
}

final class ExpiryRaceWpdb
{
    public string $prefix = 'wp_';
    public array $queries = [];
    public ?string $fail_update_table = null;
    public ?string $fail_query = null;
    private ?array $snapshot = null;
    public bool $confirm_after_candidate_query = false;
    public object $booking;
    public object $departure;

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
        if ('START TRANSACTION' === $sql) {
            if ('START TRANSACTION' === $this->fail_query) {
                return false;
            }
            $this->snapshot = [clone $this->booking, clone $this->departure];
            return true;
        }
        if ('ROLLBACK' === $sql) {
            if ($this->snapshot) {
                [$this->booking, $this->departure] = [clone $this->snapshot[0], clone $this->snapshot[1]];
            }
            return true;
        }
        if ('COMMIT' === $sql && 'COMMIT' === $this->fail_query) {
            return false;
        }
        return $sql !== $this->fail_query;
    }

    public function get_col(string $sql): array
    {
        $candidates = 'new' === $this->booking->status
            && (int) $this->booking->held_seats > 0
            && $this->booking->hold_expires_at < current_time('mysql', true)
            ? [(int) $this->booking->id]
            : [];
        if ($this->confirm_after_candidate_query && $candidates) {
            $this->booking->status = 'contacted';
            $this->booking->hold_expires_at = '2026-10-25 12:00:00';
        }
        return $candidates;
    }

    public function get_row(string $sql): ?object
    {
        if (str_contains($sql, 'wp_ts_bookings')) {
            return clone $this->booking;
        }
        if (str_contains($sql, 'wp_ts_departures')) {
            return clone $this->departure;
        }
        return null;
    }

    public function update(string $table, array $data, array $where): int|false
    {
        if ($this->fail_update_table === $table) {
            return false;
        }
        $target = str_ends_with($table, 'ts_bookings') ? $this->booking : $this->departure;
        foreach ($data as $key => $value) {
            $target->{$key} = $value;
        }
        return 1;
    }
}

require dirname(__DIR__) . '/core-plugin/includes/class-ts-booking-workflow.php';

$wpdb = new ExpiryRaceWpdb();
$wpdb->booking = (object) [
    'id' => 901,
    'booking_type' => 'departure',
    'departure_id' => 5,
    'status' => 'new',
    'held_seats' => 2,
    'group_size' => 2,
    'hold_expires_at' => '2026-10-24 11:59:00',
];
$wpdb->departure = (object) [
    'id' => 5,
    'status' => 'available',
    'total_seats' => 12,
    'booked_seats' => 3,
    'held_seats' => 2,
];
$wpdb->confirm_after_candidate_query = true;
$GLOBALS['wpdb'] = $wpdb;

$expired = TS_Booking_Workflow::release_expired_holds();
if ('contacted' !== $wpdb->booking->status || 2 !== (int) $wpdb->booking->held_seats || '2026-10-25 12:00:00' !== $wpdb->booking->hold_expires_at) {
    throw new RuntimeException('Hold cleanup cancelled a renewed booking after the expiry candidate query.');
}
if (3 !== (int) $wpdb->departure->booked_seats || 2 !== (int) $wpdb->departure->held_seats) {
    throw new RuntimeException('Expiry race changed the renewed held-seat counts.');
}
if (0 !== $expired) {
    throw new RuntimeException('Expiry cleanup must count only holds actually expired under lock.');
}

$wpdb = new ExpiryRaceWpdb();
$wpdb->booking = (object) [
    'id' => 902,
    'booking_type' => 'departure',
    'departure_id' => 5,
    'status' => 'new',
    'held_seats' => 2,
    'group_size' => 2,
    'hold_expires_at' => '2026-10-24 13:00:00',
];
$wpdb->departure = (object) [
    'id' => 5,
    'status' => 'available',
    'total_seats' => 12,
    'booked_seats' => 3,
    'held_seats' => 2,
];
$wpdb->fail_update_table = 'wp_ts_departures';
$GLOBALS['wpdb'] = $wpdb;

$result = TS_Booking_Workflow::transition_status(902, 'confirmed');
if (!is_wp_error($result) || 'new' !== $wpdb->booking->status || 3 !== (int) $wpdb->departure->booked_seats || 2 !== (int) $wpdb->departure->held_seats) {
    throw new RuntimeException('A failed departure-seat update must fail the whole confirmation and roll back.');
}
if (!in_array('ROLLBACK', $wpdb->queries, true)) {
    throw new RuntimeException('A failed seat reconciliation must roll back the transaction.');
}

$wpdb = new ExpiryRaceWpdb();
$wpdb->booking = (object) [
    'id' => 903,
    'booking_type' => 'departure',
    'departure_id' => 5,
    'status' => 'new',
    'held_seats' => 2,
    'group_size' => 2,
    'hold_expires_at' => '2026-10-24 13:00:00',
];
$wpdb->departure = (object) [
    'id' => 5,
    'status' => 'available',
    'total_seats' => 12,
    'booked_seats' => 3,
    'held_seats' => 2,
];
$wpdb->fail_update_table = 'wp_ts_bookings';
$GLOBALS['wpdb'] = $wpdb;

$result = TS_Booking_Workflow::transition_status(903, 'confirmed');
if (!is_wp_error($result) || 'new' !== $wpdb->booking->status || 3 !== (int) $wpdb->departure->booked_seats || 2 !== (int) $wpdb->departure->held_seats) {
    throw new RuntimeException('A failed booking status write must fail and roll back the seat reconciliation.');
}

$wpdb = new ExpiryRaceWpdb();
$wpdb->booking = (object) [ 'id' => 904, 'booking_type' => 'departure', 'departure_id' => 5, 'status' => 'new', 'held_seats' => 2, 'group_size' => 2, 'hold_expires_at' => '2026-10-24 13:00:00' ];
$wpdb->departure = (object) [ 'id' => 5, 'status' => 'available', 'total_seats' => 12, 'booked_seats' => 3, 'held_seats' => 2 ];
$wpdb->fail_query = 'START TRANSACTION';
$GLOBALS['wpdb'] = $wpdb;
$result = TS_Booking_Workflow::transition_status(904, 'confirmed');
if (!is_wp_error($result) || 'new' !== $wpdb->booking->status || 3 !== (int) $wpdb->departure->booked_seats) {
    throw new RuntimeException('A transaction-start failure must not execute or report the booking transition.');
}

$wpdb = new ExpiryRaceWpdb();
$wpdb->booking = (object) [ 'id' => 905, 'booking_type' => 'departure', 'departure_id' => 5, 'status' => 'new', 'held_seats' => 2, 'group_size' => 2, 'hold_expires_at' => '2026-10-24 13:00:00' ];
$wpdb->departure = (object) [ 'id' => 5, 'status' => 'available', 'total_seats' => 12, 'booked_seats' => 3, 'held_seats' => 2 ];
$wpdb->fail_query = 'COMMIT';
$GLOBALS['wpdb'] = $wpdb;
$result = TS_Booking_Workflow::transition_status(905, 'confirmed');
if (!is_wp_error($result) || 'new' !== $wpdb->booking->status || 3 !== (int) $wpdb->departure->booked_seats || 2 !== (int) $wpdb->departure->held_seats || !in_array('ROLLBACK', $wpdb->queries, true)) {
    throw new RuntimeException('A commit failure must report failure and roll back seat and booking changes.');
}

$wpdb = new ExpiryRaceWpdb();
$wpdb->booking = (object) [ 'id' => 906, 'booking_type' => 'departure', 'departure_id' => 5, 'status' => 'new', 'held_seats' => 2, 'group_size' => 2, 'hold_expires_at' => '2026-10-24 11:59:00' ];
$wpdb->departure = (object) [ 'id' => 5, 'status' => 'available', 'total_seats' => 12, 'booked_seats' => 3, 'held_seats' => 2 ];
$GLOBALS['wpdb'] = $wpdb;
$released = TS_Booking_Workflow::release_expired_holds();
if (1 !== $released || 'cancelled' !== $wpdb->booking->status || 0 !== (int) $wpdb->booking->held_seats || null !== $wpdb->booking->hold_expires_at || 3 !== (int) $wpdb->departure->booked_seats || 0 !== (int) $wpdb->departure->held_seats || 'available' !== $wpdb->departure->status) {
    throw new RuntimeException('An actually expired hold must release exactly its reserved seats and become cancelled.');
}
if (0 !== TS_Booking_Workflow::release_expired_holds()) {
    throw new RuntimeException('Repeated expiry cleanup must be idempotent.');
}

$wpdb = new ExpiryRaceWpdb();
$wpdb->booking = (object) [ 'id' => 907, 'booking_type' => 'departure', 'departure_id' => 5, 'status' => 'new', 'held_seats' => 2, 'group_size' => 2, 'hold_expires_at' => '2026-10-24 13:00:00' ];
$wpdb->departure = (object) [ 'id' => 5, 'status' => 'available', 'total_seats' => 12, 'booked_seats' => 3, 'held_seats' => 2 ];
$GLOBALS['wpdb'] = $wpdb;
$confirmed = TS_Booking_Workflow::transition_status(907, 'confirmed');
TS_Booking_Workflow::transition_status(907, 'confirmed');
if ('confirmed' !== $confirmed->status || 'confirmed' !== $wpdb->booking->status || 0 !== (int) $wpdb->booking->held_seats || 5 !== (int) $wpdb->departure->booked_seats || 0 !== (int) $wpdb->departure->held_seats) {
    throw new RuntimeException('Repeated confirmation must book the held seats exactly once.');
}
TS_Booking_Workflow::transition_status(907, 'cancelled');
TS_Booking_Workflow::transition_status(907, 'cancelled');
if ('cancelled' !== $wpdb->booking->status || 3 !== (int) $wpdb->departure->booked_seats || 0 !== (int) $wpdb->departure->held_seats) {
    throw new RuntimeException('Repeated cancellation must release confirmed seats exactly once.');
}

echo "PASS: expiry races, hold release, idempotent transitions, and database-failure boundaries.\n";
