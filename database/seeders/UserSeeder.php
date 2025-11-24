<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User 1
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'organizer_status' => null,
            'phone' => '083456789012',
        ]);

        // User 2
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'organizer_status' => null,
            'phone' => '083456789013',
        ]);

        // User 3
        User::create([
            'name' => 'Michael Brown',
            'email' => 'michael@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'organizer_status' => null,
            'phone' => '083456789014',
        ]);

        // User 4 - untuk testing booking
        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'organizer_status' => null,
            'phone' => '083456789015',
        ]);
    }
}