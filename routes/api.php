<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        // 短信验证码
        $api->post('verificationCodes', 'VerificationCodesController@store')
            ->name('api.verificationCodes.store');
        // 用户添加
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');


        // 图片验证码
        $api->post('captchas', 'CaptchasController@store')
            ->name('api.captchas.store');
        // 管理员登录
        $api->post('authorizations/login', 'LoginController@store')
            ->name('api.admin.login');
        // 刷新 token
        $api->put('authorizations/current', 'LoginController@update')
            ->name('api.admin.authorizations.update');
        // 删除token
        $api->delete('authorizations/current', 'LoginController@destroy')
            ->name('api.admin.authorizations.destroy');

        // 需要 token 验证的接口
        $api->group(['middleware' => 'api.auth'], function ($api) {
            // 当前登录用户信息
            $api->get('authorizations/info', 'UsersController@me')
                ->name('api.user.show');
            // 用户注册
            $api->post('users', 'UsersController@store')
                ->name('api.users.store');
        });

    });
});
