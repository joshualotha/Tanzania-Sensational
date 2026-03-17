<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'body',
        'url',
        'severity',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];
}

