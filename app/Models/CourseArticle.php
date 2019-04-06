<?php

namespace App\Models;

class CourseArticle extends Model
{
    protected $fillable = ['title', 'body', 'slug', 'policy'];

    // 生成 url
    public function link($params = [])
    {
        return route('course.articles.show', array_merge([$this->section->book->id, $this->id], $params));
    }

    /**
     * 获取对应章节
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id', 'id')->with('book');
    }

    /**
     * 对应用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 对应回复
    public function replies()
    {
        return $this->hasMany(Reply::class, 'article_id')->where('model', CourseArticle::class);
    }

    // 更新评论数
    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
