<?php

namespace App\Http\Controllers;

use App\Models\CourseBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseBookRequest;
use Illuminate\Support\Facades\Auth;

class CourseBooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$books = CourseBook::with('image')->paginate();
		return view('pages.course_books.index', compact('books'));
	}

    public function show(CourseBook $book)
    {
        $sections = $book->sections;

        return view('pages.course_books.show', compact('book', 'sections'));
    }

	public function create(CourseBook $book)
	{
        $this->authorize('admin', $book);
		return view('pages.course_books.create_and_edit', compact('book'));
	}

	public function store(CourseBookRequest $request, CourseBook $book)
	{
        $this->authorize('admin', $book);
        $book->fill($request->all());
        $book->user_id = Auth::id();
        $book->save();
		return redirect()->route('course.books.show', $book->id)->with('success', '教程创建成功.');
	}

	public function edit(CourseBook $book)
	{
        $this->authorize('admin', $book);
		return view('pages.course_books.create_and_edit', compact('book'));
	}

	public function update(CourseBookRequest $request, CourseBook $book)
	{
        $this->authorize('admin', $book);
        $book->update($request->all());

		return redirect()->route('course.books.show', $book->id)->with('message', '更新成功.');
	}

	public function destroy(CourseBook $book)
	{
        $this->authorize('admin', $book);
        $book->delete();

		return redirect()->route('course.books.index')->with('message', '删除成功.');
	}
}
