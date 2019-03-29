<?php

namespace App\Http\Controllers;

use App\Models\CourseArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseArticleRequest;

class CourseArticlesController extends Controller
{
    // 教程书籍 id
    protected $book_id = null;

    protected $data = [];

    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);

        $this->book_id = $this->data['book_id'] = $request->book;
        if (empty($this->book_id)) {
            abort(403, '非法访问');
        }
    }

	public function index(Request $request)
	{
        $data = $this->data;
		$articles = CourseArticle::paginate();
		return view('pages.course_articles.index', compact('articles', 'data'));
	}

    public function show(CourseArticle $course_article)
    {
        return view('course_articles.show', compact('course_article'));
    }

	public function create(CourseArticle $article)
	{
        $data = $this->data;
		return view('pages.course_articles.create_and_edit', compact('article', 'data'));
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
