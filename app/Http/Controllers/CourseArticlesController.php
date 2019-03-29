<?php

namespace App\Http\Controllers;

use App\Models\CourseArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseArticleRequest;

class CourseArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$course_articles = CourseArticle::paginate();
		return view('course_articles.index', compact('course_articles'));
	}

    public function show(CourseArticle $course_article)
    {
        return view('course_articles.show', compact('course_article'));
    }

	public function create(CourseArticle $course_article)
	{
		return view('course_articles.create_and_edit', compact('course_article'));
	}

	public function store(CourseArticleRequest $request)
	{
		$course_article = CourseArticle::create($request->all());
		return redirect()->route('course_articles.show', $course_article->id)->with('message', 'Created successfully.');
	}

	public function edit(CourseArticle $course_article)
	{
        $this->authorize('update', $course_article);
		return view('course_articles.create_and_edit', compact('course_article'));
	}

	public function update(CourseArticleRequest $request, CourseArticle $course_article)
	{
		$this->authorize('update', $course_article);
		$course_article->update($request->all());

		return redirect()->route('course_articles.show', $course_article->id)->with('message', 'Updated successfully.');
	}

	public function destroy(CourseArticle $course_article)
	{
		$this->authorize('destroy', $course_article);
		$course_article->delete();

		return redirect()->route('course_articles.index')->with('message', 'Deleted successfully.');
	}
}