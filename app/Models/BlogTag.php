<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    protected $fillable = ['name'];

    public function hasTag($name)
    {
        return $this->where('name', $name)->exists();
    }

    public function getTag($name)
    {
        return $this->where('name', $name)->pluck('id');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\BlogArticle', 'blog_tags_link_articles');
    }
}
