<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'introduction' => 'max:80',
            'github_name' => 'max:80',
            'real_name' => 'max:20',
            'city' => 'max:40',
            'company' => 'max:80',
            'jobtitle' => 'max:80',
            'personal_website' => 'max:120',
            'signature' => 'max:255',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
            'wechat_qrcode' => 'mimes:jpeg,bmp,png,gif',
            'payment_qrcode' => 'mimes:jpeg,bmp,png,gif',
            'gender' => 'in:male,female',
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' =>'头像必须是 jpeg, bmp, png, gif 格式的图片',
            'wechat_qrcode.mimes' =>'微信账号二维码必须是 jpeg, bmp, png, gif 格式的图片',
            'payment_qrcode.mimes' =>'支付二维码必须是 jpeg, bmp, png, gif 格式的图片',
            'avatar.dimensions' => '图片的清晰度不够，宽和高需要 208px 以上',
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
            'introduction.max' => '个人简介最多 80 个字符。',
            'real_name.max' => '真实姓名最多 20 个字符。',
            'city.max' => '城市最多 40 个字符。',
            'company.max' => '公司或组织名称最多 80 个字符。',
            'jobtitle.max' => '职位头衔最多 80 个字符。',
            'personal_website.max' => '个人网站最多 120 个字符。',
            'signature.max' => '署名最多 255 个字符。',
        ];
    }
}
