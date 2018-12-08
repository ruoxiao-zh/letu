<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class AdminRequest extends BaseRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'     => 'required|string|max:255|unique:admins',
                    'password' => 'required|string|min:6',
                ];
                break;
            case 'PUT':
                $adminId = \Auth::guard('admin')->id();
                return [
                    'name'     => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('admins')->ignore($adminId, 'id')
                    ],
                    'password' => 'required|string|min:6',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required'     => '管理员不能为空',
            'name.string'       => '管理员用户名必须为字符串类型',
            'name.max'          => '管理员用户名最大字符长度不能超过 255 个字符',
            'name.unique'       => '管理员用户名已存在, 请更换其它用户名',
            'password.required' => '密码不能为空',
            'password.string'   => '密码必须为字符串类型',
            'password.min'      => '密码最小字符长度不能低于 6 个字符',
        ];
    }
}
