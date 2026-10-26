<?php

declare(strict_types=1);

$manifest_path = __DIR__ . '/../migration/blog-import-manifest.json';
if (!is_file($manifest_path)) {
    throw new RuntimeException('Blog import manifest is required for the approved 12-article slice.');
}

$manifest = json_decode((string) file_get_contents($manifest_path), true, 512, JSON_THROW_ON_ERROR);

function blog_manifest_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$expected_slugs = [
    'altitude-acclimatization-a-practical-guide',
    'safari-after-the-summit-best-pairings',
    'training-for-kilimanjaro-8-weeks-no-guesswork',
    'what-a-kilimanjaro-day-looks-like-on-the-mountain',
    'the-5-ecological-zones-of-kilimanjaro',
    'why-group-departures-work-and-when-they-dont',
    'zanzibar-the-perfect-recovery-itinerary',
    'moshi-arrival-hotels-and-what-to-expect',
    'common-mistakes-first-time-trekkers-make',
    'lemosho-vs-machame-choosing-your-route',
    'how-to-tip-on-kilimanjaro-simple-breakdown',
    'kilimanjaro-packing-list-what-actually-matters',
];

$posts = $manifest['posts'] ?? [];
blog_manifest_assert(count($posts) === 12, 'The manifest must contain exactly twelve approved articles.');
blog_manifest_assert(array_column($posts, 'slug') === $expected_slugs, 'Article slugs and source index order must match exactly.');
blog_manifest_assert(count(array_unique(array_column($posts, 'content_sha256'))) === 12, 'All twelve article bodies must remain unique.');
blog_manifest_assert(count(array_filter($posts, static fn(array $post): bool => trim((string) ($post['content_html'] ?? '')) !== '')) === 12, 'Every article must have a non-empty unique body.');

$broken_media = null;
foreach ($posts as $post) {
    blog_manifest_assert(preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) ($post['published_at'] ?? '')) === 1, 'Every post must preserve its source date.');
    blog_manifest_assert(!empty($post['title']) && !empty($post['category_name']), 'Every post must have its source title and category.');
    if ('how-to-tip-on-kilimanjaro-simple-breakdown' === $post['slug']) {
        $broken_media = $post;
    }
}

blog_manifest_assert(is_array($broken_media), 'The source 404 media record must remain in the manifest.');
blog_manifest_assert('https://images.unsplash.com/photo-1520975958225-3f61d2c4ca0b?auto=format&fit=crop&w=1600&q=80' === ($broken_media['source_hero_image_url'] ?? null), 'Keep the exact failed source URL for audit.');
blog_manifest_assert('source_404_omit' === ($broken_media['hero_media_status'] ?? null), 'Mark the failed source image as omitted.');
blog_manifest_assert('' === ($broken_media['hero_image_url'] ?? null), 'Do not substitute a failed source image.');

$required_repairs = [
    '/trekking' => '/kilimanjaro-pillar/',
    '/trekking/lemosho' => '/kilimanjaro-pillar/',
    '/trekking/machame' => '/kilimanjaro-pillar/',
    '/trekking/marangu' => '/kilimanjaro-pillar/',
    '/trekking/rongai' => '/kilimanjaro-pillar/',
    '/trekking/northern-circuit' => '/kilimanjaro-pillar/',
    '/trekking/after/gear-list' => '/gear-checklist/',
    '/trekking/after/getting-there' => '/kilimanjaro-pillar/',
    '/trekking/during/food-and-drinks' => '/kilimanjaro-pillar/',
    '/trekking/health/altitude-sickness' => '/kilimanjaro-pillar/',
    '/trekking/health/diamox' => '/kilimanjaro-pillar/',
    '/trekking/health/oxygen' => '/kilimanjaro-pillar/',
    '/plan/group-departures' => '/group-departures/',
    '/plan/training-guide' => '/training-guide/',
    '/safaris/guide' => '/safari-guide/',
    '/blog/how-to-tip-on-kilimanjaro' => '/blog/how-to-tip-on-kilimanjaro-simple-breakdown',
];
blog_manifest_assert(($manifest['link_repairs'] ?? null) === $required_repairs, 'Link repairs must use only the verified staging destinations.');

$all_content = implode("\n", array_column($posts, 'content_html'));
foreach ($required_repairs as $source => $target) {
    blog_manifest_assert(str_contains($all_content, 'href="' . $target . '"'), 'Repaired target is missing from the article bodies: ' . $target);
    blog_manifest_assert(!str_contains($all_content, 'href="' . $source . '"'), 'Unrepaired source route remains in article content: ' . $source);
}

fwrite(STDOUT, "PASS: 12-post source manifest, unique bodies, media omission, and verified link repairs.\n");
