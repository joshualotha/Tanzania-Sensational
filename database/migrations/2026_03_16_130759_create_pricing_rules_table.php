<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trekking_route_id')->constrained()->cascadeOnDelete();
            $table->integer('min_group_size')->nullable();
            $table->integer('max_group_size')->nullable();
            $table->string('season')->nullable(); // peak, shoulder, low
            $table->integer('price_per_person_cents');
            $table->string('add_on_name')->nullable();
            $table->integer('add_on_price_cents')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
