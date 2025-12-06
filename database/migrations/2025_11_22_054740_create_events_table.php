<?php
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
            
            $table->foreignId('organizer_id')
                  ->constrained('users')
                  ->onDelete('cascade'); 
            
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null'); 
            
        
            $table->string('name');
            $table->text('description');
            $table->dateTime('event_date');
            $table->string('location');
            $table->string('image')->nullable(); 

            $table->enum('status', ['draft', 'published', 'cancelled'])
                  ->default('published');
            
            $table->timestamps();
            
            
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