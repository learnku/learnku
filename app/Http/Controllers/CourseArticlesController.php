<?php

namespace App\Http\Controllers;

use App\Models\CourseArticle;
use App\Models\CourseBook;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseArticleRequest;
use Illuminate\Support\Facades\Auth;

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
            // abort(403, '非法访问');
        }

        $this->data = array_merge($this->data, [
            // 教程
            'books'=> CourseBook::all(),
            // 章节
            'sections'=> CourseSection::all(),
        ]);
    }

	public function index(Request $request)
	{
        $data = $this->data;
		$articles = CourseArticle::paginate();
		return view('pages.course_articles.index', compact('articles', 'data'));
	}

    public function show(CourseBook $book,CourseArticle $article)
    {
        $data = $this->data;
        return view('pages.course_articles.show', compact('article', 'data'));
    }

	public function create(CourseArticle $article)
	{
        $data = $this->data;
		return view('pages.course_articles.create_and_edit', compact('article', 'data'));
	}

	public function store(CourseArticleRequest $request, CourseArticle $article)
	{
        $data = [
            'title' => $request->title,
            'body' => $request->body,
        ];
        $article->fill($data);
        $article->course_books_id = $request->course_books_id;
        $article->courses_section_id = $request->courses_section_id;
        $article->user_id = Auth::id();
        $article->save();

		return redirect()->route('course.articles.show', [$this->book_id, $article->id])->with('message', '教程创建成功.');
	}

	public function edit(CourseArticle $article)
	{
        $this->authorize('update', $article);
		return view('pages.course_articles.create_and_edit', compact('article'));
	}

	public function update(CourseArticleRequest $request, CourseArticle $article)
	{
		$this->authorize('update', $article);
        $article->update($request->all());

		return redirect()->route('course.articles.show', $article->id)->with('message', 'Updated successfully.');
	}

	public function destroy(CourseArticle $article)
	{
		$this->authorize('destroy', $article);
		$article->delete();

		return redirect()->route('course.articles.index')->with('message', 'Deleted successfully.');
	}
}
