<?php

namespace App\Listeners;

use App\Events\CourseArticleView;
use App\Models\CourseArticle;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Cache;

class CourseArticleViewListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CourseArticleView $event)
    {
        $ip = \request()->getClientIp();
        $article = $event->article;
        // 先进行判断是否已经 浏览过
        if (!$this->hasViewedArticle($article, $ip)) {
            // 保存到数据库
            $article->view_count = $article->view_count + 1;
            $article->save();
            // 看过之后保存到 Session
            $this->storeViewedArticle($article, $ip);
        }
    }

    // 判断是否已经 浏览过
    protected function hasViewedArticle($article, $ip)
    {
        return Cache::has('viewed_Course_Articles_' . $ip . $article->id);
    }

    // 浏览过 之后将保存到 Session
    protected function storeViewedArticle($article, $ip)
    {
        $key = 'viewed_Course_Articles_' . $ip . $article->id;
        // 5 分钟过期
        Cache::put($key, time(), 5);
    }
}
