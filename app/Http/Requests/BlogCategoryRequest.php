<?php

namespace App\Http\Requests;


use Illuminate\Routing\Route;

class BlogCategoryRequest extends Request
{
    public function rules()
    {
        return [
            // 'name' => 'required|min:2|max:88|unique:blog_categories,name,' . $id,
            'name' => 'required|min:2|max:88',
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
