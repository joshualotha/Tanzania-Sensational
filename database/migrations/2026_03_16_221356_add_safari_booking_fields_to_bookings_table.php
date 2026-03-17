<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('safari_package_id')->nullable()->after('departure_id')->constrained('safari_packages')->nullOnDelete();
            $table->string('booking_type')->default('departure')->after('id'); // departure | safari
            $table->string('preferred_date')->nullable()->after('notes');
            $table->string('nationality')->nullable()->after('phone');
            $table->integer('adults')->default(1)->after('group_size');
            $table->integer('children')->default(0)->after('adults');
            $table->text('special_requests')->nullable()->after('notes');
            $table->string('booking_ref')->unique()->nullable()->after('id');
            $table->decimal('total_price', 12, 2)->nullable()->after('total_price_cents');
            
            // Make departure_id nullable for safari bookings
            $table->foreignId('departure_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'safari_package_id', 'booking_type', 'preferred_date', 
                'nationality', 'adults', 'children', 'special_requests',
                'booking_ref', 'total_price'
            ]);
        });
    }
};
