<?php
// database/migrations/2025_11_22_054820_create_favorites_table.php

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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            $table->foreignId('event_id')
                  ->constrained('events')
                  ->onDelete('cascade');
            
            $table->timestamps();
            
            // Unique constraint: user tidak bisa favorite event yang sama 2x
            $table->unique(['user_id', 'event_id']);
            
            // Indexes untuk performa
            $table->index('user_id');
            $table->index('event_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};