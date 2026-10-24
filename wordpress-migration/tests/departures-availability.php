<?php

declare(strict_types=1);

define('ABSPATH', __DIR__);

function current_time(string $format): string
{
    return '2026-10-24';
}

function absint($value): int
{
    return abs((int) $value);
}

final class TestWpdb
{
    public string $prefix = 'wp_';

    public function __construct(private PDO $pdo)
    {
    }

    public function prepare(string $sql, ...$args): string
    {
        return preg_replace_callback('/%[sd]/', function (array $match) use (&$args): string {
            $value = array_shift($args);
            return $match[0] === '%d' ? (string) (int) $value : $this->pdo->quote((string) $value);
        }, $sql);
    }

    public function get_results(string $sql): array
    {
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }
}

$pdo = new PDO('sqlite::memory:');
$pdo->exec('CREATE TABLE wp_ts_departures (
    id INTEGER PRIMARY KEY,
    route_name TEXT NOT NULL,
    route_url TEXT,
    departure_date TEXT NOT NULL,
    price_cents INTEGER NOT NULL,
    currency TEXT NOT NULL,
    total_seats INTEGER NOT NULL,
    booked_seats INTEGER NOT NULL,
    held_seats INTEGER NOT NULL,
    status TEXT NOT NULL
)');
$pdo->exec("INSERT INTO wp_ts_departures VALUES
    (1, 'Past route', '/past', '2026-10-23', 100000, 'USD', 12, 0, 0, 'available'),
    (2, 'Today route', '/today', '2026-10-24', 100000, 'USD', 12, 0, 0, 'available'),
    (3, 'Limited route', '/limited', '2026-11-05', 200000, 'USD', 12, 4, 2, 'limited'),
    (4, 'Full route', '/full', '2026-11-06', 200000, 'USD', 12, 12, 0, 'full'),
    (5, 'No capacity route', '/none', '2026-11-07', 200000, 'USD', 2, 1, 1, 'available'),
    (6, 'Closed route', '/closed', '2026-11-08', 200000, 'USD', 12, 0, 0, 'closed'),
    (7, 'Later route', '/later', '2026-11-12', 300000, 'USD', 12, 8, 1, 'limited')");

$GLOBALS['wpdb'] = new TestWpdb($pdo);
require dirname(__DIR__) . '/core-plugin/includes/class-ts-departures-public.php';

$rows = TS_Departures_Public::get_available_departures(2);
$ids = array_map(static fn (object $row): int => (int) $row->id, $rows);
if ($ids !== [2, 3]) {
    throw new RuntimeException('Expected only the earliest two current/future departures with seats; got ' . json_encode($ids));
}

$first = TS_Departures_Public::get_available_departures(1);
if (count($first) !== 1 || (int) $first[0]->id !== 2) {
    throw new RuntimeException('Expected the limit to return the earliest available departure.');
}

echo "PASS: upcoming departure inventory excludes past, full, closed, and sold-out rows; ordering and limit work.\n";
