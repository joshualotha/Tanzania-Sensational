<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'booking_ref', 'booking_type', 'departure_id', 'safari_package_id',
        'customer_name', 'email', 'phone', 'nationality',
        'country',
        'group_size', 'adults', 'children',
        'held_seats', 'hold_expires_at', 'last_contacted_at',
        'total_price_cents', 'total_price',
        'status', 'notes', 'preferred_date', 'special_requests'
    ];

    protected $casts = [
        'hold_expires_at' => 'datetime',
        'last_contacted_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($booking) {
            if (!$booking->booking_ref) {
                $booking->booking_ref = 'TS-' . strtoupper(Str::random(8));
            }
        });
    }

    public function departure(): BelongsTo
    {
        return $this->belongsTo(Departure::class);
    }

    public function safariPackage(): BelongsTo
    {
        return $this->belongsTo(SafariPackage::class);
    }
}
