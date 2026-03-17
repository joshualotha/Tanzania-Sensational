<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisualAsset extends Model
{
    protected $fillable = ['section', 'key', 'url', 'type', 'metadata'];

    protected $casts = [
        'metadata' => 'array',
    ];
}
