<?php

declare(strict_types=1);

$GLOBALS['blog_concurrency_insert_count'] = 0;

class BlogConcurrencyTestWpdb
{
    public string $posts = 'wp_posts';
    public int $collision_id = 9001;
    public array $events = [];

    public function prepare(string $query, ...$args): string
    {
        foreach ($args as $arg) {
            $query = preg_replace('/%s/', "'" . addslashes((string) $arg) . "'", $query, 1);
        }
        return $query;
    }

    public function query(string $query)
    {
        $this->events[] = $query;
        return 0;
    }

    public function get_var(string $query)
    {
        $this->events[] = $query;
        return str_contains($query, 'FOR UPDATE') ? $this->collision_id : null;
    }
}

$GLOBALS['wpdb'] = new BlogConcurrencyTestWpdb();

function get_posts(array $args = []): array
{
    // Simulate a stale preflight/cache result: the competing slug is not returned here.
    return [];
}

function wp_slash($value)
{
    return $value;
}

function term_exists(string $term, string $taxonomy)
{
    return ['term_id' => 7, 'term_taxonomy_id' => 7];
}

function is_wp_error($value): bool
{
    return false;
}

function wp_insert_post(array $postarr, bool $wp_error = false)
{
    $GLOBALS['wpdb']->events[] = 'WP_INSERT_POST';
    ++$GLOBALS['blog_concurrency_insert_count'];
    throw new RuntimeException('Test sentinel: reached wp_insert_post without rejecting the competing slug.');
}

function blog_concurrency_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

require_once __DIR__ . '/../migration/blog-import-runtime.php';

function blog_concurrency_assert_slug_locked(string $label, callable $apply): void
{
    $GLOBALS['wpdb'] = new BlogConcurrencyTestWpdb();
    $GLOBALS['blog_concurrency_insert_count'] = 0;
    $error = null;
    try {
        $apply();
    } catch (Throwable $caught) {
        $error = $caught;
    }

    $events = $GLOBALS['wpdb']->events;
    $isolation_index = array_search('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ', $events, true);
    $start_index = array_search('START TRANSACTION', $events, true);
    $lock_index = false;
    foreach ($events as $index => $event) {
        if (is_string($event) && str_contains($event, 'FORCE INDEX (post_name)') && str_contains($event, 'FOR UPDATE')) {
            $lock_index = $index;
            break;
        }
    }

    blog_concurrency_assert(
        $error instanceof RuntimeException && str_contains($error->getMessage(), 'duplicate'),
        $label . ' apply must reject a slug that appears after preflight.'
    );
    blog_concurrency_assert(
        false !== $isolation_index && false !== $start_index && false !== $lock_index
            && $isolation_index < $start_index && $start_index < $lock_index,
        $label . ' apply must take a repeatable-read indexed locking read inside its transaction.'
    );
    blog_concurrency_assert(
        0 === $GLOBALS['blog_concurrency_insert_count'],
        $label . ' apply must not insert after the locking read finds a competing slug.'
    );
}

$manifest = json_decode((string) file_get_contents(__DIR__ . '/../migration/blog-import-manifest.json'), true, 512, JSON_THROW_ON_ERROR);
$record = $manifest['posts'][0];
blog_concurrency_assert_slug_locked('Post', static function () use ($record): void {
    ts_blog_apply_post($record);
});

$page_plan = [
    'action' => 'create',
    'kind' => 'blog_page',
    'expected' => [
        'post_type' => 'page',
        'post_name' => 'blog',
        'post_title' => 'Blog',
        'post_content' => '',
    ],
];
blog_concurrency_assert_slug_locked('Page', static function () use ($page_plan): void {
    ts_blog_apply_resource($page_plan);
});

fwrite(STDOUT, "PASS: post and layout creates lock slug ranges and reject post-preflight collisions.\n");
