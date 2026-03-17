<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('route_itinerary_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trekking_route_id')->constrained()->cascadeOnDelete();
            $table->integer('day_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('elevation')->nullable(); // highest elevation in m
            $table->string('distance')->nullable();
            $table->string('hiking_time')->nullable();
            $table->string('habitat')->nullable();
            $table->string('accommodation')->nullable();
            $table->string('meals')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('route_itinerary_days');
    }
};
