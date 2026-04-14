<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BlogHtmlContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_blog_post_with_content_html(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'info@tanzaniasensational.co.tz',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($user);

        $res = $this->postJson('/api/admin/blog', [
            'title' => 'Test Post',
            'slug' => 'test-post',
            'excerpt' => 'Hello',
            'author' => 'Admin',
            'category' => 'Testing',
            'hero_image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80',
            'content_html' => '<p><strong>Hello</strong> world</p>',
            'published_at' => now()->toISOString(),
        ]);

        $res->assertCreated();
        $res->assertJsonPath('content_html', '<p><strong>Hello</strong> world</p>');
    }

    public function test_public_index_only_returns_published_posts(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'info@tanzaniasensational.co.tz',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($user);

        $this->postJson('/api/admin/blog', [
            'title' => 'Draft Post',
            'slug' => 'draft-post',
            'content_html' => '<p>Draft</p>',
            'published_at' => null,
        ])->assertCreated();

        $this->postJson('/api/admin/blog', [
            'title' => 'Published Post',
            'slug' => 'published-post',
            'content_html' => '<p>Published</p>',
            'published_at' => now()->toISOString(),
        ])->assertCreated();

        $public = $this->getJson('/api/blog');
        $public->assertOk();
        $slugs = collect($public->json())->pluck('slug')->all();

        $this->assertContains('published-post', $slugs);
        $this->assertNotContains('draft-post', $slugs);
    }
}

