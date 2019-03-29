<?php

namespace App\Models;

class BlogCategory extends Model
{
    protected $fillable = ['name', 'description', 'cascade'];

    /**
     * 分类下文章
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(BlogArticle::class, 'category_id');
    }

    /**
     * 更新分类下文章数
     */
    public function updatePostCount()
    {
        $this->post_count = $this->articles->count();
        $this->save();
    }
}
