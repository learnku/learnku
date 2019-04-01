<?php

namespace App\Http\Controllers;

use App\Models\CourseBook;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSectionRequest;

class CourseSectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(CourseBook $book)
	{
        $sections = $book->sections()->paginate();
		return view('pages.course_sections.index', compact('book', 'sections'));
	}

	public function create(CourseBook $book, CourseSection $section)
	{
		return view('pages.course_sections.create_and_edit', compact('book', 'section'));
	}

	public function store(CourseSectionRequest $request, CourseBook $book, CourseSection $section)
	{
        $section->fill($request->all());
        $section->course_book_id = $book->id;
        $section->save();
		return redirect()->route('course.sections.index', $book->id)->with('message', '创建成功.');
	}

	public function edit(CourseBook $book, CourseSection $section)
	{
        $this->authorize('admin', $section);
		return view('pages.course_sections.create_and_edit', compact('book', 'section'));
	}

	public function update(CourseSectionRequest $request,CourseBook $book, CourseSection $section)
	{
		$this->authorize('admin', $section);
        $section->update($request->all());
        $section->fill($request->all());
        $section->course_book_id = $book->id;
        $section->save();

		return redirect()->route('course.sections.index', $book->id)->with('message', '更新成功.');
	}

	public function destroy(CourseBook $book, CourseSection $section)
	{
		$this->authorize('admin', $section);
        $section->delete();

		return redirect()->route('course.sections.index', $book->id)->with('message', '删除成功.');
	}
}
