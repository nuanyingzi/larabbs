<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'content' => 'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => '请输入内容。',
            'content.min' => '内容不能少于 2 个字符。',
        ];
    }
}
