<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BlogCategoryResource;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Requests\BlogCategoryRequest;

class BlogCategoriesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    // api 创建分类
	public function store(BlogCategoryRequest $request, BlogCategory $category)
	{
        $user = $this->user();
        $user_id = $user->id;
	    $category_id = $request->category_id;
	    $data = [
            'name' => $request->name,
            'description' => $request->description,
            'cascade' => $request->cascade,
        ];
        if (empty($name)) {
            $data['name'] = $category_id;
        }
        $category->fill($data);
        $category->user_id = $user_id;
        $category->save();

        return $this->created(new BlogCategoryResource($category));
	}

	public function destroy(BlogCategory $blog_category)
	{

	}
}
