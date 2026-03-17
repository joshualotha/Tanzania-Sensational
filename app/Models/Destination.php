<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'slug', 'name', 'meta_subtitle', 'meta_tag', 'overview', 'meta_quote', 
        'hero_image', 'meta_coordinates', 'meta_elevation', 'best_time',
        'meta_encounter_rate', 'meta_tier', 'meta_tracking',
        'highlights', 'gallery', 'atmosphere_vitals', 'atmosphere_footer',
        'wildlife_vitals', 'wildlife_footer'
    ];

    protected $casts = [
        'highlights' => 'array',
        'gallery' => 'array',
        'atmosphere_vitals' => 'array',
        'wildlife_vitals' => 'array',
    ];
}
