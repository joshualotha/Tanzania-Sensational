<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trekking_route_id')->constrained()->cascadeOnDelete();
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->integer('price_cents');
            $table->integer('available_seats')->default(12);
            $table->integer('booked_seats')->default(0);
            $table->string('status')->default('Available'); // Available, Limited, Full
            $table->string('summit_night')->nullable();
            $table->string('meeting_point')->nullable();
            $table->string('briefing_date')->nullable();
            $table->text('description')->nullable();
            $table->json('inclusions')->nullable();
            $table->json('exclusions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departures');
    }
};
