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
            
            // Foreign Key
            $table->foreignId('event_id')
                  ->constrained('events')
                  ->onDelete('cascade'); // Hapus ticket jika event dihapus
            
            // Ticket Information
            $table->string('name'); // Contoh: VIP, Regular, Early Bird
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // Harga tiket (max 99,999,999.99)
            
            // Quota Management
            $table->integer('quota'); // Total kuota tiket
            $table->integer('quota_remaining'); // Sisa kuota (berkurang saat booking)
            
            $table->string('image')->nullable(); // Path ke gambar tiket
            
            $table->timestamps();
            
            // Index untuk performa
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