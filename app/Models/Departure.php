<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departure extends Model
{
    protected $fillable = [
        'trekking_route_id', 'departure_date', 'return_date', 'price_cents',
        'total_seats', 'available_seats', 'booked_seats', 'held_seats', 'status', 'summit_night',
        'meeting_point', 'briefing_date', 'description', 'inclusions', 'exclusions'
    ];

    protected $appends = [
        'start_date',
        'end_date',
        'price',
        'remaining_seats',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'return_date' => 'date',
        'inclusions' => 'array',
        'exclusions' => 'array',
    ];

    public function trekkingRoute(): BelongsTo
    {
        return $this->belongsTo(TrekkingRoute::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getStartDateAttribute(): ?string
    {
        return $this->departure_date?->toDateString();
    }

    public function getEndDateAttribute(): ?string
    {
        return $this->return_date?->toDateString();
    }

    public function getPriceAttribute(): float
    {
        return round(($this->price_cents ?? 0) / 100, 2);
    }

    public function getRemainingSeatsAttribute(): int
    {
        $total = (int)($this->total_seats ?? 0);
        $booked = (int)($this->booked_seats ?? 0);
        $held = (int)($this->held_seats ?? 0);
        return max($total - $booked - $held, 0);
    }
}
