<?php

namespace App\Models;

class BlogArticle extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    // 生成 url
    public function link($params = [])
    {
        return route('blog.articles.show', array_merge([$this->id, $this->slug], $params));
    }

    // 对应分类
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    // 对应用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 对应回复
    public function replies()
    {
        return $this->hasMany(BlogReply::class, 'article_id');
    }

    // 文章排序
    public function scopeWithOrder($query, $order)
    {
        // 不同的排序， 使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentHot();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('user', 'category');
    }

    // 按照创建时间排序
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // 按照 查看总数 排序
    public function scopeRecentHot($query)
    {
        return $query->orderBy('view_count', 'desc');
    }
}
