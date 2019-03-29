<?php

namespace App\Http\Controllers\Api;

use App\Models\BlogArticle;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BlogArticlesController extends Controller
{
    // 文章点赞
    public function upvote(BlogArticle $article)
    {
        $ip = \request()->getClientIp();

        //先进行判断是否已经 浏览过
        if (!$this->_hasVote($article, $ip)) {
            // 保存到数据库
            $article->vote_count = $article->vote_count + 1;
            $article->save();
            // 保存到 Session
            $this->_storeVote($article, $ip);
            return \response([
                'vote_count' => $article->vote_count,
                'status' => 1,
                'msg' => '点赞成功',
            ], 200);
        } else {
            return \response([
                'status' => 0,
                'msg' => '您已经赞过了',
            ], 200);
        }
    }

    // 判断是否存在
    protected function _hasVote($article, $ip)
    {
        return Cache::has('upvote_Articles_' . $ip. $article->id);
    }

    protected function _getVote($article, $ip)
    {
        return Cache::get('upvote_Articles_' . $ip. $article->id);
    }

    // 将保存到 Session
    protected function _storeVote($article, $ip)
    {
        $key = 'upvote_Articles_' . $ip . $article->id;
        // 24 小时过期
        Cache::put($key, time(), 24 * 60);
    }
}
