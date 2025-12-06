<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->enum('role', ['admin', 'organizer', 'user'])->default('user')->after('email');
            $table->enum('organizer_status', ['pending', 'approved', 'rejected'])->nullable()->after('role');
            $table->text('organizer_description')->nullable()->after('organizer_status');
            $table->string('phone')->nullable()->after('organizer_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'organizer_status', 'organizer_description', 'phone']);
        });
    }
    
};
