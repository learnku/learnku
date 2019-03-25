<?php

namespace App\Http\Requests;

class BlogCategoryRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'unique:blog_categories,name',
            'category_id'=> 'unique:blog_categories,name'
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
