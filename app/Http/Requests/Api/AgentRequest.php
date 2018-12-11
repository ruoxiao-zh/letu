<?php

namespace App\Http\Requests\Api;

class AgentRequest extends BaseRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string|max:255|unique:agents',
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\\d{8}$/',
                        'unique:agents'
                    ],
                    'password' => 'required|string|between:6,20|confirmed',
                    'password_confirmation' => 'required|string|between:6,20',
                    'province' => 'required|string',
                    'city' => 'required|string',
                    'county' => 'required|string',
                    'address' => 'required|string',
                    'email' => [
                        'required',
                        'regex:/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/',
                        'unique:agents',
                    ],
                    'qq' => 'required|string|unique:agents',
                    'verification_key' => 'required|string',
                    'verification_code' => 'required|string',
                ];
                break;
            case 'PATCH':
                return [
                    'name' => 'required|string|max:255',
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\\d{8}$/',
                    ],
                    'password' => 'required|string|between:6,20|confirmed',
                    'password_confirmation' => 'required|string|between:6,20',
                    'province' => 'required|string',
                    'city' => 'required|string',
                    'county' => 'required|string',
                    'address' => 'required|string',
                    'email' => [
                        'required',
                        'regex:/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/',
                    ],
                    'qq' => 'required|string',
                    'verification_key' => 'required|string',
                    'verification_code' => 'required|string',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => '公司名称不能为空',
            'name.string' => '公司名称必须为字符串类型',
            'name.max' => '公司名称最大长度为 255 个字符',
            'name.unique' => '公司名称已经存在',
            'phone.required' => '联系方式不能为空',
            'phone.regex' => '联系方式格式不合法',
            'phone.unique' => '联系方式已经存在',
            'password.required' => '密码不能为空',
            'password.string' => '密码必须为字符串类型',
            'password.between' => '密码长度在 6 ~ 20 个字符之间',
            'password.confirmed' => '两次密码输入不一致',
            'password_confirmation.required' => '重复密码不能为空',
            'password_confirmation.string' => '重复密码必须为字符串类型',
            'password_confirmation.between' => '重复密码长度在 6 ~ 20 个字符之间',
            'province.required' => '省份不能为空',
            'province.string' => '省份必须为字符串类型',
            'city.required' => '城市不能为空',
            'city.string' => '城市必须为字符串类型',
            'county.required' => '县(区)不能为空',
            'county.string' => '县(区)必须为字符串类型',
            'address.required' => '地址不能为空',
            'address.string' => '地址必须为字符串类型',
            'email.required' => '邮箱不能为空',
            'email.regex' => '邮箱格式不合法',
            'email.unique' => '邮箱已经存在',
            'qq.required' => 'QQ 不能为空',
            'qq.regex' => 'QQ 格式不合法',
            'qq.unique' => 'QQ 已经存在',
            'verification_key.required' => '短信验证码 key 不能为空',
            'verification_key.string' => '短信验证码 key 必须是字符串数据类型',
            'verification_code.required' => '短信验证码不能为空',
            'verification_code.string' => '短信验证码必须是字符串数据类型',
        ];
    }
}
