<?php

namespace App\Http\Controllers;

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

	public function index()
	{
		$course_sections = CourseSection::paginate();
		return view('course_sections.index', compact('course_sections'));
	}

    public function show(CourseSection $course_section)
    {
        return view('course_sections.show', compact('course_section'));
    }

	public function create(CourseSection $course_section)
	{
		return view('course_sections.create_and_edit', compact('course_section'));
	}

	public function store(CourseSectionRequest $request)
	{
		$course_section = CourseSection::create($request->all());
		return redirect()->route('course_sections.show', $course_section->id)->with('message', 'Created successfully.');
	}

	public function edit(CourseSection $course_section)
	{
        $this->authorize('update', $course_section);
		return view('course_sections.create_and_edit', compact('course_section'));
	}

	public function update(CourseSectionRequest $request, CourseSection $course_section)
	{
		$this->authorize('update', $course_section);
		$course_section->update($request->all());

		return redirect()->route('course_sections.show', $course_section->id)->with('message', 'Updated successfully.');
	}

	public function destroy(CourseSection $course_section)
	{
		$this->authorize('destroy', $course_section);
		$course_section->delete();

		return redirect()->route('course_sections.index')->with('message', 'Deleted successfully.');
	}
}