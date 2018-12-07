<?php

namespace App\Http\Requests\Api;

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'password' => 'required|string|min:6',
            'captcha_key'  => 'required|string',
            'captcha_code' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'name.string' => '用户名必须为字符串类型',
            'password.required' => '密码不能为空',
            'password.string' => '密码必须为字符串类型',
            'password.min' => '密码最小字符长度不能低于 6 个字符',
            'captcha_key.required'  => '图片验证码 key 不能为空',
            'captcha_key.string'    => '图片验证码 key 必须为字符串类型',
            'captcha_code.required' => '图片验证码不能为空',
            'captcha_code.string'   => '图片验证码必须为字符串类型',
        ];
    }
}
