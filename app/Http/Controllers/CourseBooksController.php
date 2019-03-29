<?php

namespace App\Http\Controllers;

use App\Models\CourseBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseBookRequest;

class CourseBooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$course_books = CourseBook::paginate();
		return view('course_books.index', compact('course_books'));
	}

    public function show(CourseBook $course_book)
    {
        return view('course_books.show', compact('course_book'));
    }

	public function create(CourseBook $course_book)
	{
		return view('course_books.create_and_edit', compact('course_book'));
	}

	public function store(CourseBookRequest $request)
	{
		$course_book = CourseBook::create($request->all());
		return redirect()->route('course_books.show', $course_book->id)->with('message', 'Created successfully.');
	}

	public function edit(CourseBook $course_book)
	{
        $this->authorize('update', $course_book);
		return view('course_books.create_and_edit', compact('course_book'));
	}

	public function update(CourseBookRequest $request, CourseBook $course_book)
	{
		$this->authorize('update', $course_book);
		$course_book->update($request->all());

		return redirect()->route('course_books.show', $course_book->id)->with('message', 'Updated successfully.');
	}

	public function destroy(CourseBook $course_book)
	{
		$this->authorize('destroy', $course_book);
		$course_book->delete();

		return redirect()->route('course_books.index')->with('message', 'Deleted successfully.');
	}
}