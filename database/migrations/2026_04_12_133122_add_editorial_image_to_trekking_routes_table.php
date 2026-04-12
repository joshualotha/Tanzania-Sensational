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
        Schema::table('trekking_routes', function (Blueprint $table) {
            $table->string('editorial_image')->nullable()->after('hero_image');
            $table->string('editorial_image_2')->nullable()->after('editorial_image');
            $table->text('editorial_content')->nullable()->after('editorial_image_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trekking_routes', function (Blueprint $table) {
            $table->dropColumn(['editorial_image', 'editorial_image_2', 'editorial_content']);
        });
    }
};
