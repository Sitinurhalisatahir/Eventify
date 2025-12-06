<?php
// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Music',
                'slug' => 'music',
                'icon' => 'fas fa-music',
                'color' => '#8b5cf6',
                'description' => 'Music festivals, concerts, and live performances'
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'icon' => 'fas fa-running',
                'color' => '#ef4444',
                'description' => 'Sports events, marathons, and competitions'
            ],
            [
                'name' => 'Conference',
                'slug' => 'conference',
                'icon' => 'fas fa-users',
                'color' => '#3b82f6',
                'description' => 'Professional conferences, seminars, and networking events'
            ],
            [
                'name' => 'Concert',
                'slug' => 'concert',
                'icon' => 'fas fa-microphone',
                'color' => '#ec4899',
                'description' => 'Live concerts and music performances'
            ],
            [
                'name' => 'Workshop',
                'slug' => 'workshop',
                'icon' => 'fas fa-chalkboard-teacher',
                'color' => '#10b981',
                'description' => 'Educational workshops, training, and bootcamps'
            ],
            [
                'name' => 'Exhibition',
                'slug' => 'exhibition',
                'icon' => 'fas fa-palette',
                'color' => '#f59e0b',
                'description' => 'Art exhibitions, galleries, and cultural displays'
            ],
            [
                'name' => 'Food & Drink',
                'slug' => 'food-drink',
                'icon' => 'fas fa-utensils',
                'color' => '#f97316',
                'description' => 'Food festivals, culinary events, and tastings'
            ],
            [
                'name' => 'Theater',
                'slug' => 'theater',
                'icon' => 'fas fa-theater-masks',
                'color' => '#6366f1',
                'description' => 'Theater performances, plays, and drama shows'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories seeded successfully!');
    }
}