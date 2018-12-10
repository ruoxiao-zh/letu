<?php

namespace App\Http\Requests\Api;

class CaseRequest extends BaseRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string|max:255|unique:cases',
                    'qr_code' => 'required|string|max:255',
                ];
                break;
            case 'PATCH':
                return [
                    'name' => 'required|string|max:255',
                    'qr_code' => 'required|string|max:255',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => '小程序案例名称不能为空',
            'name.string' => '小程序案例名称必须为字符串类型',
            'name.max' => '小程序案例名称最大字符长度不能超过 255 个字符',
            'name.unique' => '小程序案例名称已经存在',
            'qr_code.required' => '小程序案例二维码不能为空',
            'qr_code.string' => '小程序案例二维码必须为字符串类型',
            'qr_code.max' => '小程序案例二维码最大字符长度不能超过 255 个字符',
        ];
    }
}
