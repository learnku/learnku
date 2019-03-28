<?php

namespace App\Http\Controllers\Api;

use App\Models\BlogArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $rtn = [];
        // 搜索数组
        $search = [
            'is_all'=> $request->is_all,    // 全局搜索
            'is_blog' => $request->is_blog, // 是否是博客
            // 'is_docs' => $request->is_docs, // 是否是文档
            // 'is_book' => $request->is_book, // 是否是书籍
            // 'book_id' => $request->book_id, // 书籍 id
            'q' => $request->q,             // 搜索关键字
        ];
        // 搜索字段
        $search_link = '%' . $search['q'] . '%';

        // 博客数据
        $rtn['blog'] = DB::select(DB::raw(
            "select id,title,category_id,excerpt from blog_articles where title like :title limit 5"
        ), [
            'title'=> $search_link,
        ]);
        foreach ($rtn['blog'] as $item) {
            $item->href = route('blog.articles.show', $item->id);
        }

        // 文档数据
        return $this->json($rtn);
    }
}
