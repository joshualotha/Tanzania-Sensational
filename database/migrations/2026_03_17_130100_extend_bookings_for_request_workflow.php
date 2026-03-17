<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('country')->nullable()->after('nationality');
            $table->integer('held_seats')->default(0)->after('group_size');
            $table->timestamp('hold_expires_at')->nullable()->after('held_seats');
            $table->timestamp('last_contacted_at')->nullable()->after('hold_expires_at');
        });

        // Migrate existing booking statuses to the new workflow.
        // pending -> new, confirmed -> confirmed, cancelled -> cancelled
        DB::table('bookings')->where('status', 'pending')->update(['status' => 'new']);
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['country', 'held_seats', 'hold_expires_at', 'last_contacted_at']);
        });

        DB::table('bookings')->where('status', 'new')->update(['status' => 'pending']);
    }
};

