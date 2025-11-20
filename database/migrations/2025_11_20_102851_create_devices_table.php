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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type'); // light, heater, pump, security, etc.
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('0'); // '0' = off, '1' = on
            $table->json('config')->nullable(); // Additional settings (brightness, temperature, etc.)
            $table->string('token')->nullable()->unique(); // For testing/manual identification
            $table->string('mac_address')->nullable()->unique(); // For production auto-discovery
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
