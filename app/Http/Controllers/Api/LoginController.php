<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\Api\LoginRequest;
use App\Transformers\AdminTransformer;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        // 验证验证码
        $this->verificationCode($request);
        // 登录用户名
        $credentials = $request->only('name', 'password');

        // 用户名与密码验证
        if (!$token = auth('admin')->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    private function verificationCode($request)
    {
        $captchaData = \Cache::get($request->captcha_key);

        if (!$captchaData) {
            return $this->response->error('图片验证码已失效', 422);
        }

        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            // 验证错误就清除缓存
            \Cache::forget($request->captcha_key);

            return $this->response->errorUnauthorized('验证码错误');
        }
    }

    public function update()
    {
        $token = auth('admin')->refresh();

        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        auth('admin')->logout();

        return $this->response->noContent();
    }
}
