<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisualAsset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VisualAssetCrudTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_create_update_and_delete_visual_asset(): void
    {
        $this->actingAs($this->adminUser());

        $create = $this->postJson('/api/admin/visual-assets', [
            'section' => 'home',
            'key' => 'home_hero',
            'url' => 'https://images.example.com/a.jpg',
            'type' => 'image',
            'metadata' => ['alt' => 'Hero'],
        ]);

        $create->assertCreated();
        $this->assertDatabaseHas('visual_assets', ['key' => 'home_hero']);

        $update = $this->putJson('/api/admin/visual-assets/home_hero', [
            'section' => 'homepage',
            'key' => 'homepage_hero',
            'url' => 'https://images.example.com/b.jpg',
            'metadata' => ['alt' => 'New hero'],
        ]);

        $update->assertOk();
        $this->assertDatabaseHas('visual_assets', ['key' => 'homepage_hero', 'section' => 'homepage']);
        $this->assertDatabaseMissing('visual_assets', ['key' => 'home_hero']);

        $del = $this->deleteJson('/api/admin/visual-assets/homepage_hero');
        $del->assertNoContent();
        $this->assertDatabaseMissing('visual_assets', ['key' => 'homepage_hero']);
    }

    public function test_delete_can_optionally_remove_storage_file(): void
    {
        $this->actingAs($this->adminUser());
        Storage::fake('public');

        Storage::disk('public')->put('visual-assets/home/x.webp', 'fake');

        VisualAsset::create([
            'section' => 'home',
            'key' => 'home_test_file',
            'url' => '/storage/visual-assets/home/x.webp',
            'type' => 'image',
            'metadata' => [],
        ]);

        // Default delete keeps file
        $this->deleteJson('/api/admin/visual-assets/home_test_file')->assertNoContent();
        Storage::disk('public')->assertExists('visual-assets/home/x.webp');

        // Recreate and delete with delete_file=1
        VisualAsset::create([
            'section' => 'home',
            'key' => 'home_test_file2',
            'url' => '/storage/visual-assets/home/x.webp',
            'type' => 'image',
            'metadata' => [],
        ]);

        $this->deleteJson('/api/admin/visual-assets/home_test_file2?delete_file=1')->assertNoContent();
        Storage::disk('public')->assertMissing('visual-assets/home/x.webp');
    }
}

