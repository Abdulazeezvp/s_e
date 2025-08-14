<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=[
        'id',
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'status',
        'published_at',
    ];
}
