<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Models\BlogArticle;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class BlogArticleObserver
{
    public function saving(BlogArticle $article)
    {
        // 生成话题摘录
        $article->excerpt = make_excerpt($article->body);

        //
        dd(app(SlugTranslateHandler::class)->translate($article->title));
    }

    // 连带删除文章下的评论
    public function deleted(BlogArticle $article)
    {
        // 数据库操作需避免再次触发 Eloquent 事件，以免造成联动逻辑冲突。所以这里我们使用了 DB 类进行操作
        \DB::table('blog_replies')->where('article_id', $article->id)->delete();
    }
}
