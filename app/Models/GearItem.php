<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GearItem extends Model
{
    protected $fillable = [
        'name', 'category', 'is_required', 'description', 'sort_order'
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];
}
