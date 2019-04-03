<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogTagsController extends Controller
{
    public function show(Request $request, BlogTag $tag)
    {
        $blog_articles = $tag->articles()->withOrder($request->order)
            ->select('blog_articles.*', 'images.path as avatar_path')
            ->leftJoin('images', function ($join){
                $join->on('images.user_id', '=', 'blog_articles.user_id')
                    ->where('images.image_type', '=', 'avatar');
            })->paginate(20);

        return view('pages.blog_articles.index', compact('blog_articles', 'tag'));
    }
}
