<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('departures', 'total_seats') || !Schema::hasColumn('departures', 'held_seats')) {
            Schema::table('departures', function (Blueprint $table) {
                if (!Schema::hasColumn('departures', 'total_seats')) {
                    $table->integer('total_seats')->default(12)->after('price_cents');
                }
                if (!Schema::hasColumn('departures', 'held_seats')) {
                    $table->integer('held_seats')->default(0)->after('booked_seats');
                }
            });
        }

        // Normalize existing rows:
        // - Treat legacy `available_seats` as capacity (as per seeders/admin UI)
        // - Ensure `available_seats` becomes "remaining seats" for backward-compatible consumers.
        DB::statement("
            UPDATE departures
            SET
                total_seats = available_seats,
                available_seats = CASE
                    WHEN (available_seats - booked_seats) < 0 THEN 0
                    ELSE (available_seats - booked_seats)
                END,
                held_seats = 0
        ");
    }

    public function down(): void
    {
        Schema::table('departures', function (Blueprint $table) {
            $table->dropColumn(['total_seats', 'held_seats']);
        });
    }
};

