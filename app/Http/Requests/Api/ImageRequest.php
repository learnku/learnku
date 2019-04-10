<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->request->get('action') != 'delete') {
            $rules = [
                'image_type' => 'required|string|in:qiniu,avatar,article,course,banner',
                'image' => 'required|mimes:jpeg,bmp,png,gif',
            ];

            return $rules;
        } else {
            return [];
        }
    }
}
