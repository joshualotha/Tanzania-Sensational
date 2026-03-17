<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trekking_routes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('meta_badge')->nullable(); // e.g., "Most Scenic"
            $table->text('description')->nullable();
            $table->string('difficulty')->nullable();
            $table->integer('duration')->nullable();
            $table->string('distance')->nullable();
            $table->string('elevation_gain')->nullable();
            $table->decimal('base_price', 12, 2)->nullable();
            $table->integer('max_group_size')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('success_rate')->nullable();
            $table->json('highlights')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trekking_routes');
    }
};
