<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'image',
        'alt',
        'bg_left',
        'bg_right',
        'url',
        'title',
        'show'
    ];

    protected $casts = [
        'show'=> 'boolean'
    ];
}
