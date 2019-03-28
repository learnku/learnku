<?php

namespace App\Http\Controllers;

use App\Handlers\LearnkuUrlHandler;
use App\Models\BlogArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // Url 操作工具类
        $learnkuUrl = new LearnkuUrlHandler(url()->full());

        $search = [];
        // 搜索词
        $search['q'] = $request->q;
        // 排序
        $search['order'] = $request->order;
        if ($search['order']) {
            $search['order']  = $this->splitParams($search['order']);
        }

        // 基础查询语句
        $table = BlogArticle::withOrder($request->order)
            ->select('blog_articles.*', 'images.path as avatar_path')
            ->leftJoin('images', function ($join){
                $join->on('images.user_id', '=', 'blog_articles.user_id')
                    ->where('images.image_type', '=', 'avatar');
            });

        // 关键字查询
        if (!empty($search['q'])) {
            $table->where('title', 'like', ('%' . $search['q'] . '%'));
        }

        // 排序
        if (isset($search['order'])) {
            $table->orderBy($search['order']['name'], $search['order']['value']);
        }

        // 分页
        $blog_articles = $table->paginate(20);

        // dd($blog_articles);

        // 排序当前选中值
        switch ($learnkuUrl->show('order')) {
            case 'reply_count_desc':
                $order_select = '评论最多';
                break;
            case 'created_at_desc':
                $order_select = '最新创建';
                break;
            case 'updated_at_desc':
                $order_select = '评论最多';
                break;
            default:
                $order_select = '相关性';
                break;
        }

        // 额外基础数据
        $data = [
            'search' => [
                // 总条数
                'article_all_num' => $blog_articles->total(),
                // 搜索关键词
                'q' => $search['q'],
                // 排序： 相关性
                'order_select'=> $order_select,
                'order'=> [
                    [
                        'name' => '相关性', 'icon'=> 'random',
                        'href' => $learnkuUrl->delete(['order'=> '']),
                    ],
                    [
                        'name' => '评论最多', 'icon'=> 'comment outline',
                        'href' => $learnkuUrl->update(['order'=> 'reply_count_desc']),
                    ],
                    [
                        'name' => '最新创建', 'icon'=> 'time',
                        'href' => $learnkuUrl->update(['order'=> 'created_at_desc']),
                    ],
                    [
                        'name' => '最近活跃', 'icon'=> 'time',
                        'href' => $learnkuUrl->update(['order'=> 'updated_at_desc'])
                    ]
                ]
            ],
        ];

        $table = null;
        return view('pages.blog_articles.index', compact('blog_articles', 'data'));
    }

    /**
     * 拆分参数
     * @param string $str 例如: created_at_desc
     * @param string $splitter 默认分隔符
     * @return array [
     *      name => ':name',    // created_at
     *      value => ':value',  // desc
     * ]
     */
    protected function splitParams($str, $splitter = '_')
    {
        $export_len = strrpos($str, '_');
        return [
            'name' => substr($str, 0, $export_len),
            'value' => substr($str, $export_len + 1),
        ];
    }
}
