<?php
// database/migrations/2025_11_22_054740_create_events_table.php

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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('organizer_id')
                  ->constrained('users')
                  ->onDelete('cascade'); // Hapus event jika organizer dihapus
            
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null'); // Set null jika category dihapus
            
            // Event Information
            $table->string('name');
            $table->text('description');
            $table->dateTime('event_date');
            $table->string('location');
            $table->string('image')->nullable(); // Path ke gambar event
            
            // Status
            $table->enum('status', ['draft', 'published', 'cancelled'])
                  ->default('published');
            
            $table->timestamps();
            
            // Indexes untuk performa search & filter
            $table->index('event_date');
            $table->index('status');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};