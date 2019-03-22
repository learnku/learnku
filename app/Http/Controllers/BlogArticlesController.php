<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogArticleRequest;
use Illuminate\Support\Facades\DB;

class BlogArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
        // SELECT * FROM blog_articles left JOIN users ON blog_articles.user_id = users.id JOIN user_infos ON blog_articles.user_id = user_infos.user_id JOIN images ON blog_articles.user_id = images.user_id AND images.image_type = 'avatar';
        // SELECT blog_articles.*, images.path user_avatar FROM blog_articles left JOIN users ON blog_articles.user_id = users.id JOIN user_infos ON blog_articles.user_id = user_infos.user_id JOIN images ON blog_articles.user_id = images.user_id AND images.image_type = 'avatar'

        // DB::raw("SELECT * FROM users WHERE name =:name and password = :password"),
        /*$blog_articles = DB::table('blog_articles')
            ->leftJoin('images', function ($join){
                $join->on('images.user_id', '=', 'blog_articles.user_id')
                    ->where('images.image_type', '=', 'avatar');
            })->paginate();
        ;*/
        // dd($blog_articles);
        // paginate()
        $a = $blog_articles = BlogArticle::with(['category', 'user'])
            ->leftJoin('images', function ($join){
                $join->on('images.user_id', '=', 'blog_articles.user_id')
                    ->where('images.image_type', '=', 'avatar');
            })->toSql();

        dd($a);
        // dd(BlogArticle::with(['category', 'user'])->toSql());
		// $blog_articles = BlogArticle::with(['category', 'user'])->paginate();
		return view('pages.blog_articles.index', compact('blog_articles'));
	}

    public function show(BlogArticle $blog_article)
    {
        return view('pages.blog_articles.show', compact('blog_article'));
    }

	public function create(BlogArticle $blog_article)
	{
		return view('pages.blog_articles.create_and_edit', compact('blog_article'));
	}

	public function store(BlogArticleRequest $request)
	{
		$blog_article = BlogArticle::create($request->all());
		return redirect()->route('blog.articles.show', $blog_article->id)->with('message', 'Created successfully.');
	}

	public function edit(BlogArticle $blog_article)
	{
        $this->authorize('update', $blog_article);
		return view('pages.blog_articles.create_and_edit', compact('blog_article'));
	}

	public function update(BlogArticleRequest $request, BlogArticle $blog_article)
	{
		$this->authorize('update', $blog_article);
		$blog_article->update($request->all());

		return redirect()->route('blog.articles.show', $blog_article->id)->with('message', 'Updated successfully.');
	}

	public function destroy(BlogArticle $blog_article)
	{
		$this->authorize('destroy', $blog_article);
		$blog_article->delete();

		return redirect()->route('blog.articles.index')->with('message', 'Deleted successfully.');
	}
}
