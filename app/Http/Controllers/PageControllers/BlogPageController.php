<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogPageController extends Controller
{
    /**
     * Safely format a date for JSON serialization.
     * Returns null if the date is invalid or unparseable.
     */
    private function safeDateString(mixed $date): ?string
    {
        if (is_null($date)) {
            return null;
        }

        try {
            if ($date instanceof Carbon) {
                return $date->toAtomString();
            }
            // Try parsing as string
            $parsed = Carbon::parse($date);
            return $parsed->toAtomString();
        } catch (\Exception $e) {
            // Date is malformed — return null instead of crashing
            return null;
        }
    }

    /**
     * Build page-specific meta array for a blog post.
     */
    private function buildPostMeta(BlogPost $post): array
    {
        $appUrl = rtrim((string)config('app.url', url('/')), '/');
        $path = '/blog/' . $post->slug;

        $blogPosting = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $post->meta_description ?? strip_tags(Str::limit($post->excerpt ?? '', 155)),
            'datePublished' => $this->safeDateString($post->published_at),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author ?? 'Tanzania Sensational',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $appUrl . '/logo.png',
                ],
            ],
            'image' => $post->hero_image ? $appUrl . $post->hero_image : null,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $appUrl . $path,
            ],
        ];

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Blog', 'url' => '/blog'],
            ['label' => $post->title, 'url' => $path],
        ]);

        return [
            'title' => $post->meta_title ?? $post->title . ' | Tanzania Sensational',
            'description' => $post->meta_description ?? strip_tags(Str::limit($post->excerpt ?? $post->content ?? '', 155)),
            'og_title' => $post->meta_title ?? $post->title,
            'og_description' => $post->meta_description ?? strip_tags(Str::limit($post->excerpt ?? '', 155)),
            'og_image' => $post->hero_image ? $appUrl . $post->hero_image : null,
            'canonical' => $appUrl . $path,
            'schema' => [$blogPosting, $breadcrumbs],
        ];
    }

    /**
     * Get valid published posts, filtering out any with corrupted date fields.
     */
    private function getValidPublishedPosts()
    {
        return BlogPost::whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get()
            ->filter(function ($post) {
                // Filter out posts where published_at can't be parsed as a date
                try {
                    if ($post->published_at instanceof Carbon) {
                        return true;
                    }
                    Carbon::parse($post->published_at);
                    return true;
                } catch (\Exception $e) {
                    return false;
                }
            })
            ->values(); // Reset array keys after filtering
    }

    /**
     * Display the blog list page.
     */
    public function index()
    {
        $posts = $this->getValidPublishedPosts();

        $appUrl = rtrim((string)config('app.url', url('/')), '/');

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Blog', 'url' => '/blog'],
        ]);

        return Inertia::render('blog/BlogList', [
            'posts' => $posts,
            'meta' => [
                'title' => 'Tanzania Travel Blog | Kilimanjaro & Safari Tips | Tanzania Sensational',
                'description' => 'Expert trekking and safari guidance from Tanzania Sensational. Kilimanjaro climbing tips, safari planning advice, Zanzibar travel guides, and Tanzania travel insights.',
                'og_title' => 'Tanzania Travel Blog | Kilimanjaro & Safari Tips',
                'og_description' => 'Expert trekking and safari guidance from Tanzania Sensational.',
                'og_image' => null,
                'canonical' => $appUrl . '/blog',
                'schema' => [$breadcrumbs],
            ],
        ]);
    }

    /**
     * Display a single blog post.
     */
    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->whereNotNull('published_at')
            ->firstOrFail();

        $allPosts = $this->getValidPublishedPosts();

        return Inertia::render('blog/BlogDetail', [
            'post' => $post,
            'allPosts' => $allPosts,
            'meta' => $this->buildPostMeta($post),
        ]);
    }
}
