<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogArticleRequest;

class BlogArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$blog_articles = BlogArticle::with(['category', 'user'])->paginate();
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
