<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTagsLinkArticle extends Model
{
    protected  $fillable = ['article_id', 'tag_id'];

    // 删除 article_id 对应的条目
    public function deleteArticleItem($article_id)
    {
        $this->where('article_id', $article_id)->delete();
    }
}
