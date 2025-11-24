<?php
// database/migrations/2025_11_22_055203_create_reviews_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            $table->foreignId('event_id')
                  ->constrained('events')
                  ->onDelete('cascade');
            
            $table->foreignId('booking_id')
                  ->constrained('bookings')
                  ->onDelete('cascade'); // Hanya bisa review jika sudah booking
            
            // Review Information
            $table->integer('rating'); // 1-5 stars
            $table->text('comment')->nullable();
            
            $table->timestamps();
            
            // Unique constraint: user hanya bisa review 1x per event
            $table->unique(['user_id', 'event_id']);
            
            // Indexes untuk performa
            $table->index('event_id');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};