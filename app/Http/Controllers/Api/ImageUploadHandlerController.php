<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\ImageUploadHandlerRequest;
use App\Services\OSS;

class ImageUploadHandlerController extends Controller
{
    // 允许上传图片类型
    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

    public function save($file, $folder)
    {
        // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
        // 文件夹切割能让查找效率更高。
        $folder_name = "images/$folder/" . date("Ym/d", time());
        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ? : 'png';

        // 拼接文件名
        $filename = time() . '_' . str_random(10) . '.' . $extension;

        // 如果上传的不是图片将终止操作
        if (!in_array($extension, $this->allowed_ext)) {
            return $this->response->error("上传的文件格式必须是 'png', 'jpg', 'gif', 'jpeg' 格式类型", 422);
        }

        // 阿里 OSS 图片上传
        $result = OSS::publicUpload(env('ALIOSS_BUCKETNAME'), $folder_name . '/' . $filename, $file->getRealPath());
        if ($result) {
            $result = [
                'path' => OSS::getPublicObjectURL(env('ALIOSS_BUCKETNAME'), $folder_name . '/' . $filename),
            ];

            return $this->response->array($result)->setStatusCode(201);
        } else {
            return response()->json(['msg' => '图片上传失败'], 422);
        }
    }

    /**
     * 图片上传
     *
     * @param ImageUploadHandlerRequest $request
     */
    public function upload(ImageUploadHandlerRequest $request)
    {
        return $this->save($request->images, $request->dirname);
    }
}
