<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class ImageUploadHandlerRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'images' => 'mimes:jpg,jpeg,bmp,png,gif|dimensions:min_width=100,min_height=100',
            'dirname' => [
                'required',
                Rule::in([
                    'template',
                    'articles',
                    'hotels',
                    'rooms',
                    'attractions',
                    'services',
                    'slideshows',
                    'walk',
                    'plate'
                ]),
            ],
        ];
    }

    public function messages()
    {
        return [
            'images.mimes' => '图片必须是 jpg, jpeg, bmp, png, gif 格式',
            'images.dimensions' => '图片的清晰度不够，宽和高需要 100px 以上',
            'dirname.required' => '图片上传文件目录不能为空',
            'dirname.in' => '图片上传文件目录只能是 [companies, articles, hotels, rooms, attractions, services, slideshows, walk, plate] 数组中的任一值',
        ];
    }
}
