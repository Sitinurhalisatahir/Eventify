<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ⚠️ URUTAN PENTING!
        // Categories dulu karena Events butuh category_id
        // Users dulu karena Events butuh organizer_id
        
        $this->call([
            CategorySeeder::class,      // 1. Buat categories dulu
            AdminSeeder::class,          // 2. Buat admin
            OrganizerSeeder::class,      // 3. Buat organizers
            UserSeeder::class,           // 4. Buat users
            EventSeeder::class,          // 5. Buat events (butuh categories & organizers)
        ]);
    }
}