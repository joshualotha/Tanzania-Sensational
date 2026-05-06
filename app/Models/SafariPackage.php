<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafariPackage extends Model
{
    protected $fillable = [
        'slug', 'name', 'category', 'meta_tag', 'meta_title', 'meta_description',
        'duration', 'description',
        'hero_image', 'base_price', 'inclusions', 'exclusions', 'itinerary'
    ];

    protected $casts = [
        'inclusions' => 'array',
        'exclusions' => 'array',
        'itinerary' => 'array',
    ];
}
