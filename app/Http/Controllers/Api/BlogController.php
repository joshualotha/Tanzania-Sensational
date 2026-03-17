<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // Public: only show published posts.
        return response()->json(
            BlogPost::query()
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:blog_posts,slug',
            'author' => 'nullable|string',
            'category' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'content' => 'nullable|array',
            'content_html' => 'nullable|string',
            'hero_image' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        if (empty($validated['content']) && empty($validated['content_html'])) {
            return response()->json(['message' => 'Content is required.'], 422);
        }

        $post = BlogPost::create($validated);
        return response()->json($post, 201);
    }

    public function show($slug)
    {
        // Public: only show published posts.
        $post = BlogPost::where('slug', $slug)->whereNotNull('published_at')->firstOrFail();
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'string|max:255',
            'slug' => 'string|unique:blog_posts,slug,' . $id,
            'author' => 'nullable|string',
            'category' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'content' => 'array',
            'content_html' => 'nullable|string',
            'hero_image' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $post->update($validated);
        return response()->json($post);
    }

    /**
     * Admin: list all posts including drafts.
     */
    public function adminIndex()
    {
        return response()->json(
            BlogPost::query()
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->get()
        );
    }

    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();
        return response()->json(null, 204);
    }
}
