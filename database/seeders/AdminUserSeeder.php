<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'info@tanzaniasensational.co.tz'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'), // Ensure you change this in production!
            ]
        );
    }
}
