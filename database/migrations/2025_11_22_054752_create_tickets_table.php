<?php
// database/migrations/2025_11_22_054752_create_tickets_table.php

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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            
            
            $table->foreignId('event_id')
                  ->constrained('events')
                  ->onDelete('cascade');

            $table->string('name'); 
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); 
            
      
            $table->integer('quota'); 
            $table->integer('quota_remaining'); 
            
            $table->string('image')->nullable();
            
            $table->timestamps();
            
            $table->index('event_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};