<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'image',
        'alt',
        'bg_color',
        'url',
        'title',
        'show'
    ];

    protected $casts = [
        'show'=> 'boolean'
    ];
}
