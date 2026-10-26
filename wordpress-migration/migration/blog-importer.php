<?php
/**
 * Validated, create-only importer for the approved Tanzania Sensational blog slice.
 *
 * @package Tanzania_Sensational
 */

/** Build a stable digest for the source-managed fields of one article. */
function ts_blog_source_record_hash(array $post): string
{
    $fields = [
        'slug' => (string) ($post['slug'] ?? ''),
        'source_url' => (string) ($post['source_url'] ?? ''),
        'title' => (string) ($post['title'] ?? ''),
        'category_name' => (string) ($post['category_name'] ?? ''),
        'published_at' => (string) ($post['published_at'] ?? ''),
        'author_display' => (string) ($post['author_display'] ?? ''),
        'featured' => (bool) ($post['featured'] ?? false),
        'excerpt' => (string) ($post['excerpt'] ?? ''),
        'hero_image_url' => (string) ($post['hero_image_url'] ?? ''),
        'source_hero_image_url' => (string) ($post['source_hero_image_url'] ?? ''),
        'hero_image_alt' => (string) ($post['hero_image_alt'] ?? ''),
        'hero_media_status' => (string) ($post['hero_media_status'] ?? ''),
        'source_body_sha256' => (string) ($post['source_body_sha256'] ?? ''),
        'content_sha256' => (string) ($post['content_sha256'] ?? ''),
        'link_repairs_applied' => (array) ($post['link_repairs_applied'] ?? []),
    ];

    return hash('sha256', json_encode($fields, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
}

/** Validate the reviewed import data without requiring WordPress. */
function ts_blog_validate_manifest(array $manifest): void
{
    if (1 !== (int) ($manifest['schema_version'] ?? 0)) {
        throw new RuntimeException('Unsupported blog manifest schema version.');
    }

    $posts = $manifest['posts'] ?? null;
    if (!is_array($posts) || 12 !== count($posts)) {
        throw new RuntimeException('The approved blog manifest must contain exactly twelve posts.');
    }

    $slugs = [];
    $body_hashes = [];
    $featured_count = 0;
    foreach ($posts as $post) {
        if (!is_array($post)) {
            throw new RuntimeException('Every blog manifest entry must be an object.');
        }

        foreach (['slug', 'source_url', 'title', 'category_name', 'published_at', 'author_display', 'hero_media_status', 'source_body_sha256', 'content_sha256', 'content_html'] as $required) {
            if (!isset($post[$required]) || '' === (string) $post[$required]) {
                throw new RuntimeException('Missing required blog manifest field: ' . $required);
            }
        }

        $slug = (string) $post['slug'];
        if (1 !== preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug) || isset($slugs[$slug])) {
            throw new RuntimeException('Invalid or duplicate blog slug: ' . $slug);
        }
        $slugs[$slug] = true;

        if (1 !== preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $post['published_at'])) {
            throw new RuntimeException('Invalid source publication date for ' . $slug);
        }
        [$year, $month, $day] = array_map('intval', explode('-', (string) $post['published_at']));
        if (!checkdate($month, $day, $year)) {
            throw new RuntimeException('Impossible source publication date for ' . $slug);
        }

        foreach (['source_body_sha256', 'content_sha256'] as $hash_key) {
            if (1 !== preg_match('/^[a-f0-9]{64}$/', (string) $post[$hash_key])) {
                throw new RuntimeException('Invalid SHA-256 field ' . $hash_key . ' for ' . $slug);
            }
        }
        $actual_content_hash = hash('sha256', (string) $post['content_html']);
        if (!hash_equals((string) $post['content_sha256'], $actual_content_hash)) {
            throw new RuntimeException('Article body hash mismatch for ' . $slug);
        }
        $body_hashes[] = $actual_content_hash;

        if (empty($post['source_url']) || 0 !== strpos((string) $post['source_url'], 'https://')) {
            throw new RuntimeException('Invalid source article URL for ' . $slug);
        }
        if (!isset($post['excerpt']) || !is_string($post['excerpt'])) {
            throw new RuntimeException('Article excerpt must be a string for ' . $slug);
        }
        if (!array_key_exists('featured', $post) || !is_bool($post['featured'])) {
            throw new RuntimeException('Featured flag must be an explicit boolean for ' . $slug);
        }
        if ($post['featured']) {
            ++$featured_count;
        }

        $source_image = (string) ($post['source_hero_image_url'] ?? '');
        $display_image = (string) ($post['hero_image_url'] ?? '');
        if ('source_404_omit' === $post['hero_media_status']) {
            if ('' === $source_image || '' !== $display_image) {
                throw new RuntimeException('Failed source hero media must be retained for audit and omitted for ' . $slug);
            }
        } elseif ('' === $source_image || $source_image !== $display_image || 0 !== strpos($source_image, 'https://')) {
            throw new RuntimeException('Usable source hero media must remain exact for ' . $slug);
        }
    }

    if (1 !== $featured_count || 12 !== count(array_unique($body_hashes))) {
        throw new RuntimeException('The manifest must have one featured article and twelve unique bodies.');
    }

    $repairs = $manifest['link_repairs'] ?? null;
    if (!is_array($repairs) || [] === $repairs) {
        throw new RuntimeException('The reviewed staging link repair map is required.');
    }

    $normalized_repairs = [];
    foreach ($repairs as $source => $target) {
        if (!is_string($source) || !is_string($target)) {
            throw new RuntimeException('Blog link repairs must use relative internal routes.');
        }
        $source_path = ts_blog_normalize_internal_link_path($source);
        $target_path = ts_blog_normalize_internal_link_path($target);
        if (null === $source_path || null === $target_path || !str_starts_with($source, '/') || !str_starts_with($target, '/') || $source_path === $target_path) {
            throw new RuntimeException('Blog link repairs must use distinct relative internal routes.');
        }
        if (array_key_exists($source_path, $normalized_repairs)) {
            throw new RuntimeException('Blog link repair sources must be unique after URL normalization: ' . $source);
        }
        $normalized_repairs[$source_path] = $target_path;
    }

    $all_href_paths = [];
    $used_repairs = [];
    foreach ($posts as $post) {
        $slug = (string) $post['slug'];
        $article_href_paths = ts_blog_extract_internal_href_paths((string) $post['content_html']);
        foreach ($article_href_paths as $href_path) {
            $all_href_paths[$href_path] = true;
        }

        $applied = $post['link_repairs_applied'] ?? null;
        if (!is_array($applied)) {
            throw new RuntimeException('Per-article link repair metadata is required for ' . $slug);
        }
        foreach ($applied as $source => $target) {
            if (!is_string($source) || !is_string($target)) {
                throw new RuntimeException('Per-article link repair entries must be route strings for ' . $slug);
            }
            $source_path = ts_blog_normalize_internal_link_path($source);
            $target_path = ts_blog_normalize_internal_link_path($target);
            if (null === $source_path || null === $target_path || !array_key_exists($source_path, $normalized_repairs) || $normalized_repairs[$source_path] !== $target_path) {
                throw new RuntimeException('Per-article repair does not match the reviewed source-to-target map for ' . $slug);
            }
            if (in_array($source_path, $article_href_paths, true)) {
                throw new RuntimeException('Unrepaired source link remains in ' . $slug . ': ' . $source);
            }
            if (!in_array($target_path, $article_href_paths, true)) {
                throw new RuntimeException('Reviewed repair target is missing from ' . $slug . ': ' . $target);
            }
            $used_repairs[$source_path] = true;
        }
    }

    foreach ($normalized_repairs as $source_path => $target_path) {
        if (isset($all_href_paths[$source_path])) {
            throw new RuntimeException('Unrepaired source link remains in the blog content: ' . $source_path);
        }
        if (!isset($used_repairs[$source_path])) {
            throw new RuntimeException('Reviewed link repair is not applied to any article: ' . $source_path);
        }
    }
}

/** Normalize a known internal URL path, discarding query/fragment variants. */
function ts_blog_normalize_internal_link_path(string $href): ?string
{
    $href = html_entity_decode(trim($href), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    if ('' === $href) {
        return null;
    }

    $parts = parse_url($href);
    if (!is_array($parts)) {
        return null;
    }
    $scheme = strtolower((string) ($parts['scheme'] ?? ''));
    if ('' !== $scheme && !in_array($scheme, ['http', 'https'], true)) {
        return null;
    }
    $host = strtolower((string) ($parts['host'] ?? ''));
    if ('' !== $host && !in_array($host, ['tanzaniasensational.com', 'www.tanzaniasensational.com', 'test.tanzaniasensational.com'], true)) {
        return null;
    }

    $path = rawurldecode((string) ($parts['path'] ?? ''));
    if ('' === $path) {
        $path = '/';
    }
    if (!str_starts_with($path, '/')) {
        return null;
    }

    $segments = [];
    foreach (explode('/', $path) as $segment) {
        if ('' === $segment || '.' === $segment) {
            continue;
        }
        if ('..' === $segment) {
            array_pop($segments);
            continue;
        }
        $segments[] = $segment;
    }

    return [] === $segments ? '/' : '/' . implode('/', $segments);
}

/** Extract normalized internal href paths from HTML anchor attributes. */
function ts_blog_extract_internal_href_paths(string $html): array
{
    preg_match_all('/\bhref\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]+))/is', $html, $matches, PREG_SET_ORDER);
    $paths = [];
    foreach ($matches as $match) {
        $href = '';
        foreach ([1, 2, 3] as $group) {
            if (isset($match[$group]) && '' !== $match[$group]) {
                $href = (string) $match[$group];
                break;
            }
        }
        $path = ts_blog_normalize_internal_link_path($href);
        if (null !== $path) {
            $paths[] = $path;
        }
    }

    return $paths;
}

/**
 * Build a create-only plan; existing records are accepted only when their
 * importer ownership and full managed-field snapshot are intact.
 */
function ts_blog_build_import_plan(array $manifest, array $existing_by_slug): array
{
    ts_blog_validate_manifest($manifest);
    $plan = [];

    foreach ($manifest['posts'] as $post) {
        $slug = (string) $post['slug'];
        if (!array_key_exists($slug, $existing_by_slug)) {
            $plan[] = ['action' => 'create', 'slug' => $slug, 'record_hash' => ts_blog_source_record_hash($post)];
            continue;
        }

        $existing = $existing_by_slug[$slug];
        $record_hash = ts_blog_source_record_hash($post);
        if (!is_array($existing) || $slug !== ($existing['source_slug'] ?? null)) {
            throw new RuntimeException('Refusing to overwrite unowned record at slug: ' . $slug);
        }
        if ('ready' !== (string) ($existing['state_marker'] ?? '')) {
            throw new RuntimeException('Refusing to resume an incomplete or unknown import state at slug: ' . $slug);
        }
        if (!hash_equals($record_hash, (string) ($existing['import_hash'] ?? ''))) {
            throw new RuntimeException('Source data changed after import at slug: ' . $slug);
        }
        $stored_snapshot = (string) ($existing['snapshot_hash'] ?? '');
        $actual_snapshot = (string) ($existing['actual_snapshot_hash'] ?? '');
        if ('' === $stored_snapshot || !hash_equals($stored_snapshot, $actual_snapshot)) {
            throw new RuntimeException('Refusing to overwrite an edited importer-owned record at slug: ' . $slug);
        }

        $plan[] = ['action' => 'unchanged', 'slug' => $slug, 'record_hash' => $record_hash];
    }

    return $plan;
}

/** Build Elementor Theme Builder conditions for only approved imported posts. */
function ts_blog_build_single_template_conditions(array $post_ids): array
{
    if ([] === $post_ids) {
        throw new RuntimeException('The blog single template requires at least one imported post ID.');
    }

    $conditions = [];
    foreach ($post_ids as $post_id) {
        if (!is_int($post_id) || $post_id < 1 || isset($conditions[$post_id])) {
            throw new RuntimeException('Invalid or duplicate blog post ID in single-template conditions.');
        }
        $conditions[$post_id] = 'include/singular/post/' . $post_id;
    }



    return array_values($conditions);
}

/** Fail closed unless the run targets private staging and is properly confirmed. */
function ts_blog_validate_run_mode(bool $apply, bool $confirmed, bool $is_admin, string $site_origin, $blog_public): void
{
    $origin = parse_url($site_origin);
    $valid_origin = is_array($origin)
        && 'https' === strtolower((string) ($origin['scheme'] ?? ''))
        && 'test.tanzaniasensational.com' === strtolower((string) ($origin['host'] ?? ''))
        && (!isset($origin['port']) || 443 === (int) $origin['port'])
        && !isset($origin['user'])
        && !isset($origin['pass'])
        && in_array((string) ($origin['path'] ?? ''), ['', '/'], true)
        && !isset($origin['query'])
        && !isset($origin['fragment']);
    if (!$valid_origin) {
        throw new RuntimeException('Blog importer is locked to the HTTPS origin https://test.tanzaniasensational.com.');
    }
    if (!in_array($blog_public, [0, '0', false], true)) {
        throw new RuntimeException('Blog import requires staging search visibility to remain disabled.');
    }
    if (!$apply && $confirmed) {
        throw new RuntimeException('Staging-write confirmation is only valid with --apply.');
    }
    if ($apply && !$confirmed) {
        throw new RuntimeException('Applying blog imports requires --confirm-staging-write.');
    }
    if ($apply && !$is_admin) {
        throw new RuntimeException('Applying blog imports requires a staging administrator.');
    }
}

/** Verify a complete, checksummed backup stored outside the WordPress web root. */
function ts_blog_verify_backup_directory(string $directory, string $document_root): array
{
    $backup_root = realpath($directory);
    $public_root = realpath($document_root);
    if (false === $backup_root || false === $public_root || !is_dir($backup_root) || !is_dir($public_root)) {
        throw new RuntimeException('Backup directory or WordPress document root is unavailable.');
    }

    $public_prefix = rtrim($public_root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    if ($backup_root === $public_root || str_starts_with($backup_root . DIRECTORY_SEPARATOR, $public_prefix)) {
        throw new RuntimeException('Staging backups must be stored outside the public web root.');
    }

    $checksum_path = realpath($backup_root . DIRECTORY_SEPARATOR . 'SHA256SUMS');
    if (false === $checksum_path || dirname($checksum_path) !== $backup_root || !is_file($checksum_path) || !is_readable($checksum_path)) {
        throw new RuntimeException('Backup SHA256SUMS file is missing or invalid.');
    }

    $contents = file($checksum_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!is_array($contents) || [] === $contents) {
        throw new RuntimeException('Backup SHA256SUMS file is empty or unreadable.');
    }

    $verified = [];
    foreach ($contents as $line) {
        if (1 !== preg_match('/^([a-f0-9]{64})  ([A-Za-z0-9._-]+)$/i', (string) $line, $matches)) {
            throw new RuntimeException('Backup SHA256SUMS contains a malformed entry.');
        }
        $expected_hash = strtolower($matches[1]);
        $name = $matches[2];
        if (isset($verified[$name])) {
            throw new RuntimeException('Backup SHA256SUMS contains a duplicate entry: ' . $name);
        }

        $path = realpath($backup_root . DIRECTORY_SEPARATOR . $name);
        if (false === $path || dirname($path) !== $backup_root || !is_file($path) || !is_readable($path)) {
            throw new RuntimeException('A checksummed backup file is missing or outside the backup directory: ' . $name);
        }
        $actual_hash = hash_file('sha256', $path);
        if (!is_string($actual_hash) || !hash_equals($expected_hash, strtolower($actual_hash))) {
            throw new RuntimeException('Backup checksum verification failed: ' . $name);
        }
        $verified[$name] = $path;
    }

    foreach (['database.sql', 'custom-plugins.tgz', 'plugin-inventory.txt', 'theme-inventory.txt'] as $required) {
        if (!array_key_exists($required, $verified)) {
            throw new RuntimeException('Backup is incomplete; required file is missing from SHA256SUMS: ' . $required);
        }
    }

    return $verified;
}
