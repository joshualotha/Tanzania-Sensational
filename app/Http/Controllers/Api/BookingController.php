<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\BookingReplyToCustomer;
use App\Mail\BookingRequestConfirmationCustomer;
use App\Mail\BookingRequestNotificationAdmin;
use App\Models\Booking;
use App\Models\Departure;
use App\Models\SafariPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    private const HOLD_HOURS = 36;

    private function recalcDepartureAvailability(Departure $departure): void
    {
        // Backward compatible: keep `available_seats` as "remaining seats"
        $departure->available_seats = $departure->remaining_seats;

        if ($departure->remaining_seats <= 0) {
            $departure->status = 'Full';
        } elseif ($departure->remaining_seats <= 3) {
            $departure->status = 'Limited';
        } else {
            $departure->status = 'Available';
        }
    }

    /**
     * Departure-based booking (trekking).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'departure_id' => 'required|exists:departures,id',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'group_size' => 'required|integer|min:1|max:20',
            'special_requests' => 'nullable|string',
        ]);

        $booking = DB::transaction(function () use ($validated) {
            $departure = Departure::lockForUpdate()->findOrFail($validated['departure_id']);

            if ($departure->remaining_seats < $validated['group_size']) {
                return response()->json([
                    'message' => 'Not enough seats available for this departure.'
                ], 422);
            }

            $holdSeats = (int)$validated['group_size'];
            $totalPriceCents = (int)$departure->price_cents * $holdSeats;

            $booking = Booking::create([
                'booking_type' => 'departure',
                'departure_id' => $validated['departure_id'],
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'country' => $validated['country'] ?? null,
                'group_size' => $holdSeats,
                'total_price_cents' => $totalPriceCents,
                'total_price' => $totalPriceCents / 100,
                'status' => 'new',
                'special_requests' => $validated['special_requests'] ?? null,
                'held_seats' => $holdSeats,
                'hold_expires_at' => now()->addHours(self::HOLD_HOURS),
            ]);

            $departure->held_seats += $holdSeats;
            $this->recalcDepartureAvailability($departure);
            $departure->save();

            return $booking->load(['departure.trekkingRoute']);
        });

        if ($booking instanceof \Illuminate\Http\JsonResponse) {
            return $booking;
        }

        // Mail to admin + customer (no payment links).
        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->send(new BookingRequestNotificationAdmin($booking));
        Mail::to($booking->email)->send(new BookingRequestConfirmationCustomer($booking));

        return response()->json([
            'message' => 'Thank you for your booking request. Our team will contact you shortly to confirm details and arrange payment.',
            'booking_ref' => $booking->booking_ref,
            'booking' => $booking,
        ], 201);
    }

    /**
     * Safari package booking (non-departure).
     */
    public function storeSafari(Request $request)
    {
        $validated = $request->validate([
            'safari_package_id' => 'required|exists:safari_packages,id',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'group_size' => 'required|integer|min:1|max:20',
            'preferred_date' => 'required|string',
            'special_requests' => 'nullable|string',
        ]);

        $safari = SafariPackage::findOrFail($validated['safari_package_id']);
        $totalPrice = $safari->base_price * (int)$validated['group_size'];

        $booking = Booking::create([
            'booking_type' => 'safari',
            'safari_package_id' => $validated['safari_package_id'],
            'customer_name' => $validated['customer_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'] ?? null,
            'group_size' => (int)$validated['group_size'],
            'total_price' => $totalPrice,
            'total_price_cents' => (int)($totalPrice * 100),
            'preferred_date' => $validated['preferred_date'],
            'status' => 'new',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        $booking = $booking->load(['safariPackage']);

        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->send(new BookingRequestNotificationAdmin($booking));
        Mail::to($booking->email)->send(new BookingRequestConfirmationCustomer($booking));

        return response()->json([
            'message' => 'Thank you for your booking request. Our team will contact you shortly to confirm details and arrange payment.',
            'booking_ref' => $booking->booking_ref,
            'total_price' => $totalPrice,
            'booking' => $booking
        ], 201);
    }

    /**
     * Admin: list all bookings.
     */
    public function index()
    {
        $bookings = Booking::with(['departure.trekkingRoute', 'safariPackage'])
            ->latest()
            ->paginate(20);

        return response()->json($bookings);
    }

    /**
     * Admin: update a booking (status only for now).
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::with(['departure'])->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:new,contacted,confirmed,cancelled,NEW,CONTACTED,CONFIRMED,CANCELLED',
        ]);

        $normalizedStatus = strtolower($validated['status']);

        DB::transaction(function () use ($booking, $normalizedStatus) {
            $booking->refresh();

            if ($booking->booking_type === 'departure' && $booking->departure_id) {
                $departure = Departure::lockForUpdate()->findOrFail($booking->departure_id);

                $held = (int)($booking->held_seats ?? 0);
                $groupSize = (int)($booking->group_size ?? 0);

                // State transitions with seat reconciliation
                if ($normalizedStatus === 'contacted') {
                    $booking->last_contacted_at = now();
                    // extend hold
                    if ($held > 0) {
                        $booking->hold_expires_at = now()->addHours(self::HOLD_HOURS);
                    }
                }

                if ($normalizedStatus === 'confirmed') {
                    // Move held -> booked
                    if ($held > 0) {
                        $departure->held_seats = max(0, (int)$departure->held_seats - $held);
                        $departure->booked_seats += $held;
                        $booking->held_seats = 0;
                        $booking->hold_expires_at = null;
                    } else {
                        // If no hold exists, treat as booking confirmed for group_size (best-effort).
                        $departure->booked_seats += $groupSize;
                    }
                }

                if ($normalizedStatus === 'cancelled') {
                    // Release held seats; if already confirmed, also release booked seats for this request
                    if ($held > 0) {
                        $departure->held_seats = max(0, (int)$departure->held_seats - $held);
                        $booking->held_seats = 0;
                        $booking->hold_expires_at = null;
                    }

                    if ($booking->status === 'confirmed') {
                        $departure->booked_seats = max(0, (int)$departure->booked_seats - $groupSize);
                    }
                }

                $this->recalcDepartureAvailability($departure);
                $departure->save();
            }

            $booking->status = $normalizedStatus;
            $booking->save();
        });

        return response()->json($booking->load(['departure.trekkingRoute', 'safariPackage']));
    }

    /**
     * Admin: delete a booking. If it's a departure booking, restore seats.
     */
    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $booking = Booking::with(['departure'])->lockForUpdate()->findOrFail($id);

            if ($booking->booking_type === 'departure' && $booking->departure) {
                $departure = Departure::lockForUpdate()->findOrFail($booking->departure_id);

                $seats = (int)($booking->group_size ?? 0);
                $held = (int)($booking->held_seats ?? 0);

                if ($held > 0) {
                    $departure->held_seats = max(0, (int)$departure->held_seats - $held);
                }

                if ($booking->status === 'confirmed' && $seats > 0) {
                    $departure->booked_seats = max(0, (int)$departure->booked_seats - $seats);
                }

                $this->recalcDepartureAvailability($departure);
                $departure->save();
            }

            $booking->delete();
            return response()->json(null, 204);
        });
    }

    /**
     * Admin: reply to a booking request via email.
     */
    public function reply(Request $request, $id)
    {
        $booking = Booking::with(['departure.trekkingRoute', 'safariPackage'])->findOrFail($id);

        $validated = $request->validate([
            'subject' => 'required|string|max:160',
            'message' => 'required|string|max:10000',
        ]);

        Mail::to($booking->email)->send(new BookingReplyToCustomer(
            $booking,
            $validated['subject'],
            $validated['message'],
        ));

        $booking->last_contacted_at = now();
        if (in_array($booking->status, ['new'], true)) {
            $booking->status = 'contacted';
        }
        $booking->save();

        return response()->json([
            'message' => 'Email sent.',
            'booking' => $booking,
        ]);
    }
}
