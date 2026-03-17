<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteItineraryDay extends Model
{
    protected $fillable = [
        'trekking_route_id', 'day_number', 'title', 'description',
        'elevation', 'distance', 'hiking_time', 'habitat', 'accommodation', 'meals'
    ];

    public function trekkingRoute(): BelongsTo
    {
        return $this->belongsTo(TrekkingRoute::class);
    }
}
