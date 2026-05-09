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
        return Auth::id() == $this->route('user')->id;
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
            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'mimes:jpg,jpeg,png,gif|dimensions:min_width=200,min_height=200',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名已存在，请重新输入',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
            'name.between' => '用户名长度必须在3到25个字符之间。',
            'email.required' => '请输入邮箱',
            'email.email' => '请输入正确的邮箱格式。',
            'introduction.max' => '个人介绍最多80个字符',   
            'avatar.mimes' => '请上传jpg、jpeg、png、gif格式的图片。',
            'avatar.dimensions' => '图片尺寸必须大于200x200。',
        ];
    }
}
