<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Departure;
use App\Models\TrekkingRoute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BookingStatusTransitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_confirm_moves_held_to_booked(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $route = TrekkingRoute::create([
            'name' => 'Machame',
            'slug' => 'machame',
            'difficulty' => 'moderate',
            'duration' => 7,
            'description' => 'Test route',
        ]);

        $dep = Departure::create([
            'trekking_route_id' => $route->id,
            'departure_date' => now()->addDays(20)->toDateString(),
            'price_cents' => 200000,
            'total_seats' => 10,
            'available_seats' => 10,
            'booked_seats' => 0,
            'held_seats' => 4,
            'status' => 'Available',
        ]);

        $booking = Booking::create([
            'booking_type' => 'departure',
            'departure_id' => $dep->id,
            'customer_name' => 'John Doe',
            'email' => 'john@example.com',
            'group_size' => 4,
            'held_seats' => 4,
            'status' => 'new',
            'total_price_cents' => 800000,
        ]);

        $this->actingAs($user);

        $res = $this->putJson('/api/admin/bookings/' . $booking->id, [
            'status' => 'confirmed',
        ]);

        $res->assertOk();

        $dep->refresh();
        $booking->refresh();

        $this->assertSame('confirmed', $booking->status);
        $this->assertSame(0, (int)$booking->held_seats);
        $this->assertSame(0, (int)$dep->held_seats);
        $this->assertSame(4, (int)$dep->booked_seats);
        $this->assertSame(6, (int)$dep->available_seats);
    }
}

