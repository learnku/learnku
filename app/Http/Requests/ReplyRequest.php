<?php

namespace App\Http\Requests;

use App\Models\BlogArticle;
use App\Models\CourseArticle;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'content' => 'required|min:2',
            'model' => 'required|in:' . BlogArticle::class . ',' . CourseArticle::class,
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
