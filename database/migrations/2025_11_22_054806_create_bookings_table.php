<?php
// database/migrations/2025_11_22_054806_create_bookings_table.php

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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            $table->foreignId('ticket_id')
                  ->constrained('tickets')
                  ->onDelete('cascade');
            
            // Booking Information
            $table->string('booking_code')->unique(); // Kode unik untuk tiket digital
            $table->integer('quantity')->default(1); // Jumlah tiket yang dibeli
            $table->decimal('total_price', 10, 2); // Total harga (quantity * price)
            
            // Status Management
            $table->enum('status', ['pending', 'approved', 'cancelled', 'rejected'])
                  ->default('pending');
            
            $table->timestamp('cancelled_at')->nullable(); // Waktu cancel booking
            
            $table->timestamps();
            
            // Indexes untuk performa
            $table->index('user_id');
            $table->index('ticket_id');
            $table->index('booking_code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};