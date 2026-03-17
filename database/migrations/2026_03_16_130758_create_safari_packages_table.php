<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('safari_packages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('category')->nullable(); // SIGNATURE, EXCLUSIVE, etc.
            $table->string('meta_tag')->nullable(); // e.g., "7 Days · Manyara · Ngorongoro"
            $table->integer('duration')->nullable();
            $table->text('description')->nullable();
            $table->string('hero_image')->nullable();
            $table->decimal('base_price', 12, 2)->nullable();
            $table->json('inclusions')->nullable();
            $table->json('exclusions')->nullable();
            $table->json('itinerary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('safari_packages');
    }
};
