<?php

namespace App\Http\ViewComposers;

use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;

class BlogComposer
{
    // 博客信息
    protected $blogInfo = [];

    protected $userId = '1';

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
        $this->blogInfo['categories'] = [];
        $categories = BlogCategory::where('user_id', $this->userId)->get()->toArray();
        $tmp = array_filter($categories, function ($item) {
            return $item['cascade'] == '0';
        });
        foreach ($tmp as $item) {
            $key = $item['id'];
            $this->blogInfo['categories'][$key] = [
                'main' => $item,
                'items' => [],
            ];
        }
        $tmp = array_filter($categories, function ($item) {
            return $item['cascade'] != '0';
        });
        foreach ($tmp as $item) {
            $key = $item['cascade'];
            array_push($this->blogInfo['categories'][$key]['items'], $item);
        }

        // 标签云
        // $this->blogInfo['tags'] = BlogTag::all();
        $this->blogInfo['tags'] = DB::select(
            DB::raw("SELECT A.*,COUNT(B.id) AS count_num FROM `blog_tags` AS A LEFT JOIN blog_tags_link_articles AS B ON A.id=B.tag_id GROUP BY A.id")
        );

        // 最新文章
        $this->blogInfo['articles_news'] = array_sort($articles, function ($a, $b){
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        $this->blogInfo['articles_news'] = array_slice($this->blogInfo['articles_news'], 0, 5);

        // 最受欢迎
        $this->blogInfo['articles_hots'] = array_sort($articles, function ($a, $b){
            return (int) $b['view_count'] - (int) $a['view_count'];
        });
        $this->blogInfo['articles_hots'] = array_slice($this->blogInfo['articles_hots'], 0, 5);
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
