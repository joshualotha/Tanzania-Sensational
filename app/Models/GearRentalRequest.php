<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GearRentalRequest extends Model
{
    protected $fillable = [
        'booking_id', 'customer_name', 'email', 'items', 'status'
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
