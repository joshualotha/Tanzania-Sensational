<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingRule extends Model
{
    protected $fillable = [
        'trekking_route_id', 'min_group_size', 'max_group_size',
        'season', 'price_per_person_cents', 'add_on_name', 'add_on_price_cents'
    ];

    public function trekkingRoute(): BelongsTo
    {
        return $this->belongsTo(TrekkingRoute::class);
    }
}
