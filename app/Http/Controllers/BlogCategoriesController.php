<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;

class BlogCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$blog_categories = BlogCategory::paginate();
		return view('pages.blog_categories.index', compact('blog_categories'));
	}

    public function show(BlogCategory $blog_category)
    {
        return view('pages.blog_categories.show', compact('blog_category'));
    }

	public function create(BlogCategory $blog_category)
	{
		return view('pages.blog_categories.create_and_edit', compact('blog_category'));
	}

	public function store(BlogCategoryRequest $request)
	{
		$blog_category = BlogCategory::create($request->all());
		return redirect()->route('blog.categories.show', $blog_category->id)->with('message', 'Created successfully.');
	}

	public function edit(BlogCategory $blog_category)
	{
        $this->authorize('update', $blog_category);
		return view('pages.blog_categories.create_and_edit', compact('blog_category'));
	}

	public function update(BlogCategoryRequest $request, BlogCategory $blog_category)
	{
		$this->authorize('update', $blog_category);
		$blog_category->update($request->all());

		return redirect()->route('blog.categories.show', $blog_category->id)->with('message', 'Updated successfully.');
	}

	public function destroy(BlogCategory $blog_category)
	{
		$this->authorize('destroy', $blog_category);
		$blog_category->delete();

		return redirect()->route('blog.categories.index')->with('message', 'Deleted successfully.');
	}
}
