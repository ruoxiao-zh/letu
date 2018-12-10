<?php

namespace App\Http\Requests\Api;

class TemplateTypeRequest extends BaseRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string|max:255|unique:template_types',
                    'logo' => 'required|string|max:255',
                    'detail_picture' => 'required|string|max:255',
                ];
                break;
            case 'PATCH':
                return [
                    'name' => 'required|string|max:255',
                    'logo' => 'required|string|max:255',
                    'detail_picture' => 'required|string|max:255',
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => '模板类型名称不能为空',
            'name.string' => '模板类型名称必须为字符串类型',
            'name.max' => '模板类型名称最大字符长度不能超过 255 个字符',
            'name.unique' => '模板类型名称已经存在',
            'logo.required' => '模板类型 logo 图不能为空',
            'logo.string' => '模板类型 logo 图必须为字符串类型',
            'logo.max' => '模板类型 logo 图最大字符长度不能超过 255 个字符',
            'detail_picture.required' => '详情图不能为空',
            'detail_picture.string' => '详情图必须为字符串类型',
            'detail_picture.max' => '详情图最大字符长度不能超过 255 个字符',
        ];
    }
}
