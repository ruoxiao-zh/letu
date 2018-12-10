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
            'title.required' => '文章标题不能为空',
            'title.string' => '文章标题必须为字符串类型',
            'title.max' => '文章标题最大字符长度不能超过 255 个字符',
            'title.unique' => '文章标题已经存在',
        ];
    }
}
