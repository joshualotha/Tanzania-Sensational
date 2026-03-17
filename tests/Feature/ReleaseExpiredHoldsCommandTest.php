<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Departure;
use App\Models\TrekkingRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReleaseExpiredHoldsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_releases_expired_holds(): void
    {
        $route = TrekkingRoute::create([
            'name' => 'Rongai',
            'slug' => 'rongai',
            'difficulty' => 'moderate',
            'duration' => 7,
            'description' => 'Test route',
        ]);

        $dep = Departure::create([
            'trekking_route_id' => $route->id,
            'departure_date' => now()->addDays(25)->toDateString(),
            'price_cents' => 180000,
            'total_seats' => 12,
            'available_seats' => 10, // remaining
            'booked_seats' => 0,
            'held_seats' => 2,
            'status' => 'Available',
        ]);

        $booking = Booking::create([
            'booking_type' => 'departure',
            'departure_id' => $dep->id,
            'customer_name' => 'Expired Hold',
            'email' => 'x@example.com',
            'group_size' => 2,
            'held_seats' => 2,
            'hold_expires_at' => now()->subHour(),
            'status' => 'new',
            'total_price_cents' => 360000,
        ]);

        $this->artisan('bookings:release-expired-holds')
            ->assertExitCode(0);

        $dep->refresh();
        $booking->refresh();

        $this->assertSame(0, (int)$dep->held_seats);
        $this->assertSame(12, (int)$dep->available_seats);
        $this->assertSame('cancelled', $booking->status);
        $this->assertSame(0, (int)$booking->held_seats);
    }
}

