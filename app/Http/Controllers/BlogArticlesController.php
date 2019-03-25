<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    // 列表页
	public function index(Request $request)
	{
        $blog_articles = BlogArticle::withOrder($request->order)
        	->select('blog_articles.*', 'images.path as avatar_path')
            ->leftJoin('images', function ($join){
                $join->on('images.user_id', '=', 'blog_articles.user_id')
                    ->where('images.image_type', '=', 'avatar');
            })->paginate(20);

		// $blog_articles = BlogArticle::with(['category', 'user'])->paginate();
		return view('pages.blog_articles.index', compact('blog_articles'));
	}

    // 详情页
    public function show(BlogArticle $article)
    {
        // 回复数据
        $replies = $article->replies()->with('user')
            ->select('blog_replies.*', 'images.path as avatar_path')
            ->leftJoin('images', function ($join){
                $join->on('images.user_id', '=', 'blog_replies.user_id')
                    ->where('images.image_type', '=', 'avatar');
            })->get();

        // 文章主体
        $article->body = $this->markdownToHtml($article->body);
        return view('pages.blog_articles.show', compact('article', 'replies'));
    }

    // 创建页面
	public function create(BlogArticle $article)
	{
        $categories = BlogCategory::all();
        return view('pages.blog_articles.create_and_edit', compact('article', 'categories'));
	}

	// 保存文章
	public function store(BlogArticleRequest $request, BlogArticle $article, BlogCategory $category)
	{
	    $category_id = $request->category_id;
        $user_id = Auth::id();
        /*if ($category->where('id', $category_id)->doesntExist() && $category->where('name', trim($category_id))->doesntExist()) {
            $data = [
                'name' => trim($category_id),
                'description' => '',
                'cascade' => $request->cascade,
            ];
            $category->fill($data);
            $category->user_id = $user_id;
            $category->save();
            $category_id = $category->id;
        }*/

        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $category_id,
        ];
        $article->fill($data);
        $article->user_id = $user_id;
        $article->save();

		return redirect()->route('blog.articles.show', $article->id)->with('message', '文章创建成功.');
	}

    // 编辑页面
	public function edit(BlogArticle $article)
	{
        $categories = BlogCategory::all();
        $this->authorize('update', $article);
		return view('pages.blog_articles.create_and_edit', compact('article', 'categories'));
	}

    // 更新文章
	public function update(BlogArticleRequest $request, BlogArticle $article)
	{
		$this->authorize('update', $article);
        $category_id = $request->category_id;
        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $category_id,
        ];
        $article->update($data);

		return redirect()->route('blog.articles.show', $article->id)->with('message', '更新成功.');
	}

    // 删除文章
	public function destroy(BlogArticle $article)
	{
		$this->authorize('destroy', $article);
		$article->delete();

		return redirect()->route('blog.articles.index')->with('message', '删除成功.');
	}
}
