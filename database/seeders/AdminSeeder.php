<?php
// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Eventify',
            'email' => 'admin@eventify.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'organizer_status' => null,
            'phone' => '081234567890',
        ]);

        // Optional: Buat admin kedua untuk testing
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@eventify.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'organizer_status' => null,
            'phone' => '081234567891',
        ]);
    }
}