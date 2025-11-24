<?php
// database/seeders/EventSeeder.php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil organizer yang approved
        $organizer1 = User::where('email', 'organizer1@eventify.com')->first();
        $organizer2 = User::where('email', 'organizer2@eventify.com')->first();

        // Ambil categories
        $musicCategory = Category::where('slug', 'music')->first();
        $sportsCategory = Category::where('slug', 'sports')->first();
        $conferenceCategory = Category::where('slug', 'conference')->first();
        $concertCategory = Category::where('slug', 'concert')->first();

        // Event 1 - Rock Festival
        $event1 = Event::create([
            'organizer_id' => $organizer1->id,
            'category_id' => $musicCategory->id,
            'name' => 'Jakarta Rock Festival 2025',
            'description' => 'The biggest rock music festival in Indonesia featuring international and local bands. Join us for an unforgettable night of music!',
            'event_date' => now()->addMonths(2)->setTime(18, 0),
            'location' => 'Gelora Bung Karno Stadium, Jakarta',
            'image' => null, // bisa diisi path nanti
            'status' => 'published',
        ]);

        // Tickets untuk Event 1
        Ticket::create([
            'event_id' => $event1->id,
            'name' => 'Early Bird',
            'description' => 'Limited early bird tickets with special discount',
            'price' => 350000,
            'quota' => 500,
            'quota_remaining' => 500,
            'image' => null,
        ]);

        Ticket::create([
            'event_id' => $event1->id,
            'name' => 'Regular',
            'description' => 'Regular admission ticket',
            'price' => 500000,
            'quota' => 2000,
            'quota_remaining' => 2000,
            'image' => null,
        ]);

        Ticket::create([
            'event_id' => $event1->id,
            'name' => 'VIP',
            'description' => 'VIP access with exclusive benefits and front row seats',
            'price' => 1500000,
            'quota' => 200,
            'quota_remaining' => 200,
            'image' => null,
        ]);

        // Event 2 - Marathon
        $event2 = Event::create([
            'organizer_id' => $organizer1->id,
            'category_id' => $sportsCategory->id,
            'name' => 'Jakarta Marathon 2025',
            'description' => 'Annual marathon competition through Jakarta city. Join thousands of runners in this exciting event!',
            'event_date' => now()->addMonth()->setTime(6, 0),
            'location' => 'Starting from Monas, Jakarta',
            'image' => null,
            'status' => 'published',
        ]);

        Ticket::create([
            'event_id' => $event2->id,
            'name' => '5K Fun Run',
            'description' => '5 kilometer fun run for all ages',
            'price' => 150000,
            'quota' => 1000,
            'quota_remaining' => 1000,
            'image' => null,
        ]);

        Ticket::create([
            'event_id' => $event2->id,
            'name' => '10K Run',
            'description' => '10 kilometer competitive run',
            'price' => 250000,
            'quota' => 800,
            'quota_remaining' => 800,
            'image' => null,
        ]);

        Ticket::create([
            'event_id' => $event2->id,
            'name' => 'Half Marathon',
            'description' => '21 kilometer half marathon',
            'price' => 350000,
            'quota' => 500,
            'quota_remaining' => 500,
            'image' => null,
        ]);

        // Event 3 - Tech Conference
        $event3 = Event::create([
            'organizer_id' => $organizer2->id,
            'category_id' => $conferenceCategory->id,
            'name' => 'Indonesia Tech Summit 2025',
            'description' => 'Technology and innovation conference featuring speakers from leading tech companies.',
            'event_date' => now()->addWeeks(3)->setTime(9, 0),
            'location' => 'Jakarta Convention Center',
            'image' => null,
            'status' => 'published',
        ]);

        Ticket::create([
            'event_id' => $event3->id,
            'name' => 'Student Pass',
            'description' => 'Special student pricing (student ID required)',
            'price' => 200000,
            'quota' => 300,
            'quota_remaining' => 300,
            'image' => null,
        ]);

        Ticket::create([
            'event_id' => $event3->id,
            'name' => 'Professional',
            'description' => 'Professional pass with networking access',
            'price' => 500000,
            'quota' => 500,
            'quota_remaining' => 500,
            'image' => null,
        ]);

        // Event 4 - Jazz Concert
        $event4 = Event::create([
            'organizer_id' => $organizer2->id,
            'category_id' => $concertCategory->id,
            'name' => 'Jazz Night Under The Stars',
            'description' => 'An intimate evening of smooth jazz with talented musicians in a beautiful outdoor setting.',
            'event_date' => now()->addDays(15)->setTime(19, 0),
            'location' => 'Balai Sarbini, Jakarta',
            'image' => null,
            'status' => 'published',
        ]);

        Ticket::create([
            'event_id' => $event4->id,
            'name' => 'General Admission',
            'description' => 'Standing area general admission',
            'price' => 300000,
            'quota' => 400,
            'quota_remaining' => 400,
            'image' => null,
        ]);

        Ticket::create([
            'event_id' => $event4->id,
            'name' => 'Premium Seating',
            'description' => 'Reserved seating in premium section',
            'price' => 750000,
            'quota' => 150,
            'quota_remaining' => 150,
            'image' => null,
        ]);

        // Event 5 - Workshop (Upcoming)
        $event5 = Event::create([
            'organizer_id' => $organizer1->id,
            'category_id' => Category::where('slug', 'workshop')->first()->id,
            'name' => 'Web Development Bootcamp',
            'description' => 'Intensive 2-day web development workshop covering Laravel and React. Perfect for beginners!',
            'event_date' => now()->addWeeks(2)->setTime(9, 0),
            'location' => 'UI Campus, Depok',
            'image' => null,
            'status' => 'published',
        ]);

        Ticket::create([
            'event_id' => $event5->id,
            'name' => 'Bootcamp Access',
            'description' => 'Full 2-day bootcamp with materials and certificate',
            'price' => 500000,
            'quota' => 50,
            'quota_remaining' => 50,
            'image' => null,
        ]);
    }
}