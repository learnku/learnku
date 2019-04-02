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

        $this->data = array_merge($this->data, [
        ]);
    }

    public function show(CourseBook $book,CourseArticle $article)
    {
        if (empty($this->book_id)) {
            abort(403, '非法访问');
        }

        // 章节
        $sections = $book->sections;

        $data = $this->data;
        return view('pages.course_articles.show', compact('sections', 'article', 'data'));
    }

	public function create(CourseBook $book,CourseArticle $article)
	{
        $this->authorize('admin', $article);
        $data = $this->data;
		return view('pages.course_articles.create_and_edit', compact('book', 'article', 'data'));
	}

	public function store(CourseArticleRequest $request, CourseArticle $article)
	{
        $this->authorize('admin', $article);
        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'policy' => $request->policy
        ];
        $article->fill($data);
        // $article->course_books_id = $request->course_books_id;
        $article->course_section_id = $request->course_section_id;
        $article->user_id = Auth::id();
        $article->save();

		return redirect()->route('course.articles.show', [$this->book_id, $article->id])->with('message', '创建成功.');
	}

	public function edit(CourseBook $book, CourseArticle $article)
	{
        $data = $this->data;
        $this->authorize('admin', $article);
		return view('pages.course_articles.create_and_edit', compact('book', 'article', 'data'));
	}

	public function update(CourseArticleRequest $request, CourseBook $book, CourseArticle $article)
	{
		$this->authorize('admin', $article);
        $article->update($request->all());

		return redirect()->route('course.articles.show', [$book->id, $article->id])->with('message', '更新成功 ~');
	}

	public function destroy(CourseBook $book, CourseArticle $article)
	{
		$this->authorize('admin', $article);
		$article->delete();

		return redirect()->route('course.books.show', $book->id)->with('message', '删除成功 ~');
	}
}
