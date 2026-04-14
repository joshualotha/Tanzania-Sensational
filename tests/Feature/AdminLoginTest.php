<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_via_api_login(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'info@tanzaniasensational.co.tz',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $res = $this->postJson('/api/login', [
            'email' => 'info@tanzaniasensational.co.tz',
            'password' => 'password',
        ]);

        $res->assertOk();
        $res->assertJsonPath('user.email', 'info@tanzaniasensational.co.tz');
    }
}

