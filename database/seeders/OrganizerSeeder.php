<?php
// database/seeders/OrganizerSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Organizer 1 - APPROVED (bisa buat event)
        User::create([
            'name' => 'Event Organizer Pro',
            'email' => 'organizer1@eventify.com',
            'password' => Hash::make('password123'),
            'role' => 'organizer',
            'organizer_status' => 'approved',
            'organizer_description' => 'Professional event organizer with 5 years experience',
            'phone' => '082345678901',
        ]);

        // Organizer 2 - APPROVED
        User::create([
            'name' => 'Creative Events Studio',
            'email' => 'organizer2@eventify.com',
            'password' => Hash::make('password123'),
            'role' => 'organizer',
            'organizer_status' => 'approved',
            'organizer_description' => 'Specializing in music concerts and festivals',
            'phone' => '082345678902',
        ]);

        // Organizer 3 - PENDING (untuk testing approval)
        User::create([
            'name' => 'New Organizer',
            'email' => 'organizer.pending@eventify.com',
            'password' => Hash::make('password123'),
            'role' => 'organizer',
            'organizer_status' => 'pending',
            'organizer_description' => 'New organizer waiting for approval',
            'phone' => '082345678903',
        ]);

        // Organizer 4 - REJECTED (untuk testing delete account)
        User::create([
            'name' => 'Rejected Organizer',
            'email' => 'organizer.rejected@eventify.com',
            'password' => Hash::make('password123'),
            'role' => 'organizer',
            'organizer_status' => 'rejected',
            'organizer_description' => 'Organizer that was rejected',
            'phone' => '082345678904',
        ]);
    }
}