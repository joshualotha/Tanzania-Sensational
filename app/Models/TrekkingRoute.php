<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrekkingRoute extends Model
{
    protected $fillable = [
        'name', 'slug', 'meta_badge', 'description', 'difficulty', 'duration',
        'distance', 'elevation_gain', 'base_price', 'max_group_size', 
        'hero_image', 'success_rate', 'highlights'
    ];

    protected $casts = [
        'highlights' => 'array',
    ];

    public function itineraryDays(): HasMany
    {
        return $this->hasMany(RouteItineraryDay::class)->orderBy('day_number');
    }

    public function departures(): HasMany
    {
        return $this->hasMany(Departure::class)->orderBy('departure_date');
    }

    public function pricingRules(): HasMany
    {
        return $this->hasMany(PricingRule::class);
    }
}
