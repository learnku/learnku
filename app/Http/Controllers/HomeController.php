<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $blog_articles = BlogArticle::withOrder($request->order)
            ->select('blog_articles.*', 'images.path as avatar_path')
            ->leftJoin('images', function ($join){
                $join->on('images.user_id', '=', 'blog_articles.user_id')
                    ->where('images.image_type', '=', 'avatar');
            })->paginate(20);

        // $blog_articles = BlogArticle::with(['category', 'user'])->paginate();
        return view('home', compact('blog_articles'));

        // return view('home');
    }
}
