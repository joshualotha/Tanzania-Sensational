<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'slug', 'title', 'meta_title', 'excerpt', 'meta_description', 'content', 'content_html',
        'hero_image', 'author', 'category', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'content' => 'array',
    ];
}
