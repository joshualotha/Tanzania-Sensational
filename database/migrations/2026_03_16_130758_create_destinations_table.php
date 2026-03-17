<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('meta_subtitle')->nullable();
            $table->string('meta_tag')->nullable();
            $table->text('overview')->nullable();
            $table->text('meta_quote')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('meta_coordinates')->nullable();
            $table->string('meta_elevation')->nullable();
            $table->string('best_time')->nullable();
            $table->string('meta_encounter_rate')->nullable();
            $table->string('meta_tier')->nullable();
            $table->string('meta_tracking')->nullable();
            $table->json('highlights')->nullable();
            $table->json('gallery')->nullable();
            $table->json('atmosphere_vitals')->nullable();
            $table->string('atmosphere_footer')->nullable();
            $table->json('wildlife_vitals')->nullable();
            $table->string('wildlife_footer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
