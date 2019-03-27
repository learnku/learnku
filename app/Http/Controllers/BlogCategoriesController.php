<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use Illuminate\Support\Facades\Auth;

class BlogCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$categories = BlogCategory::where('user_id', Auth::id())->paginate();
		return view('pages.blog_categories.index', compact('categories'));
	}

    public function show(Request $request, BlogCategory $category)
    {
        $blog_articles = BlogArticle::withOrder($request->order)
            ->select('blog_articles.*', 'images.path as avatar_path')
            ->where('category_id', $category->id)
            ->leftJoin('images', function ($join){
                $join->on('images.user_id', '=', 'blog_articles.user_id')
                    ->where('images.image_type', '=', 'avatar');
            })->paginate(20);

        return view('pages.blog_articles.index', compact('blog_articles', 'category'));
    }

	public function create(BlogCategory $category)
	{
        $categories = BlogCategory::all();
		return view('pages.blog_categories.create_and_edit', compact('categories', 'category'));
	}

	public function store(BlogCategoryRequest $request, BlogCategory $category)
	{
        $category->fill($request->all());
        $category->user_id = Auth::id();
        $category->save();
		return redirect()->route('blog.categories.index', $category->id)->with('message', '创建成功.');
	}

	public function edit(BlogCategory $category)
	{
        $this->authorize('update', $category);
        $categories = BlogCategory::all();
		return view('pages.blog_categories.create_and_edit', compact('categories', 'category'));
	}

	public function update(BlogCategoryRequest $request, BlogCategory $category)
	{
		$this->authorize('update', $category);
        $category->update($request->all());

		return redirect()->route('blog.categories.index', $category->id)->with('message', '更新成功.');
	}

	public function destroy(BlogCategory $category)
	{
		$this->authorize('destroy', $category);
        $category->delete();

		return redirect()->route('blog.categories.index')->with('message', '删除成功.');
	}
}
