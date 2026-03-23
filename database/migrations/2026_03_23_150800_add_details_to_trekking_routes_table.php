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
            $table->text('inclusions')->nullable(); // JSON array
            $table->text('exclusions')->nullable(); // JSON array
        });
    }

    public function down(): void
    {
        Schema::table('trekking_routes', function (Blueprint $table) {
            $table->dropColumn(['inclusions', 'exclusions']);
        });
    }
};
