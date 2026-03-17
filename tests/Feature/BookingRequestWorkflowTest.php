<?php

namespace Tests\Feature;

use App\Mail\BookingRequestConfirmationCustomer;
use App\Mail\BookingRequestNotificationAdmin;
use App\Models\Departure;
use App\Models\TrekkingRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingRequestWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_request_creates_hold_and_sends_emails(): void
    {
        Mail::fake();

        $route = TrekkingRoute::create([
            'name' => 'Lemosho',
            'slug' => 'lemosho',
            'difficulty' => 'moderate',
            'duration' => 8,
            'description' => 'Test route',
        ]);

        $dep = Departure::create([
            'trekking_route_id' => $route->id,
            'departure_date' => now()->addDays(30)->toDateString(),
            'return_date' => now()->addDays(38)->toDateString(),
            'price_cents' => 250000,
            'total_seats' => 12,
            'available_seats' => 12,
            'booked_seats' => 0,
            'held_seats' => 0,
            'status' => 'Available',
        ]);

        $res = $this->postJson('/api/bookings', [
            'departure_id' => $dep->id,
            'customer_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+255000000',
            'country' => 'TZ',
            'group_size' => 3,
            'special_requests' => 'Vegetarian',
        ]);

        $res->assertCreated();
        $res->assertJsonPath('booking.status', 'new');
        $res->assertJsonPath('booking.held_seats', 3);

        $dep->refresh();
        $this->assertSame(3, (int)$dep->held_seats);
        $this->assertSame(9, (int)$dep->available_seats);

        Mail::assertSent(BookingRequestNotificationAdmin::class);
        Mail::assertSent(BookingRequestConfirmationCustomer::class);
    }
}

