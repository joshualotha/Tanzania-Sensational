<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Booking;
use App\Models\GearRentalRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GearRentalRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_ref' => ['nullable', 'string', 'max:32'],
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*' => ['integer', 'min:0', 'max:20'],
        ]);

        $bookingId = null;
        if (!empty($validated['booking_ref'])) {
            $bookingId = Booking::where('booking_ref', $validated['booking_ref'])->value('id');
        }

        $filteredItems = array_filter($validated['items'], fn ($qty) => (int)$qty > 0);
        if (count($filteredItems) === 0) {
            return response()->json(['message' => 'Please select at least one item to rent.'], 422);
        }

        $req = GearRentalRequest::create([
            'booking_id' => $bookingId,
            'customer_name' => $validated['customer_name'],
            'email' => $validated['email'],
            'items' => $filteredItems,
            'status' => 'new',
        ]);

        AdminNotification::create([
            'type' => 'gear_request',
            'title' => 'New gear rental request',
            'body' => trim(($req->customer_name ? $req->customer_name . ' • ' : '') . ($req->email ?? '')),
            'url' => '/ops-7f3d/gear-requests',
            'severity' => 'info',
        ]);

        return response()->json([
            'message' => 'Thank you. Your gear rental request has been received. Our team will contact you by email to confirm availability and pricing.',
            'request' => $req,
        ], 201);
    }

    public function index()
    {
        $rows = GearRentalRequest::query()
            ->with(['booking'])
            ->latest()
            ->paginate(25);

        return response()->json($rows);
    }

    public function update(Request $request, $id)
    {
        $r = GearRentalRequest::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['new', 'contacted', 'confirmed', 'cancelled'])],
        ]);

        $r->status = $validated['status'];
        $r->save();

        return response()->json($r);
    }
}

