<?php

namespace App\Http\ViewComposers;

use App\Models\BlogArticle;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;

class BlogComposer
{
    // 博客信息
    protected $blogInfo = [];

    /**
     * 创建一个新的 profile composer
     *
     * @return void
     */
    public function __construct(BlogArticle $article)
    {
        $articles = BlogArticle::all();

        $articles = $articles->toArray();

        // 汇总信息
        $this->blogInfo['collect'] = [
            'article_num'=> count($articles),// 文章数
            'view_count_num'=> array_sum(array_column($articles, 'view_count')),  // 总查看数
            'reply_count_num'=> array_sum(array_column($articles, 'reply_count')),// 总评论数
        ];

        // 文章归档
        $this->blogInfo['groupTime'] = [];
        $this->blogInfo['groupTime'] = [];
        foreach ($articles as $item){
            $a = strtotime($item['created_at']);
            $key = date('Y', $a) . date('m', $a);
            if (array_key_exists($key, $this->blogInfo['groupTime'])) {
                $this->blogInfo['groupTime'][$key]['num'] = $this->blogInfo['groupTime'][$key]['num'] + 1;
            } else {
                $this->blogInfo['groupTime'][$key]['name'] = date('Y', $a) . ' 年 ' . date('m', $a) . ' 月';
                $this->blogInfo['groupTime'][$key]['num'] = 1;
            }
        }

        // 个人分类
        $this->blogInfo['categories'] = BlogCategory::all();
        // dd($articles->toArray());
    }

    /**
     * 将数据绑定到视图。
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['common'=> [
        	'blogInfo'=> $this->blogInfo,
        ]]);
    }
}
