<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogPageController extends Controller
{
    /**
     * Display the blog list page.
     */
    public function index()
    {
        $posts = BlogPost::whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get();

        return Inertia::render('blog/BlogList', [
            'posts' => $posts,
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

        $allPosts = BlogPost::whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get();

        return Inertia::render('blog/BlogDetail', [
            'post' => $post,
            'allPosts' => $allPosts,
        ]);
    }
}
