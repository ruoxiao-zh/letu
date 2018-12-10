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
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'serializer:array'
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        // 短信验证码
        $api->post('verificationCodes', 'VerificationCodesController@store')
            ->name('api.verificationCodes.store');


        // 图片验证码
        $api->post('captchas', 'CaptchasController@store')
            ->name('api.captchas.store');
        // 管理员登录
        $api->post('authorizations/login', 'LoginController@store')
            ->name('api.admin.login');
        // 刷新 token
        $api->put('authorizations/current', 'LoginController@update')
            ->name('api.admin.authorizations.update');
        // 删除 token
        $api->delete('authorizations/current', 'LoginController@destroy')
            ->name('api.admin.authorizations.destroy');

        // 需要 token 验证的接口
        $api->group(['middleware' => 'auth:admin'], function ($api) {
            // 当前登录管理员信息
            $api->get('authorizations/info', 'AdminController@me')
                ->name('api.admin.show');
            // 管理员信息修改
            $api->put('authorizations/info', 'AdminController@update')
                ->name('api.admin.update');
            // 添加管理员
            $api->post('authorizations/info', 'AdminController@store')
                ->name('api.admin.store');

            /**
             * 模板类型管理
             */
            // 添加
            $api->post('template-types', 'TemplateTypeController@store')
                ->name('api.template-types.store');
            // 更新
            // $api->patch('template-types/{TemplateType}', function ($TemplateType) {
            //     dd($TemplateType);
            // });
            $api->patch('template-types/{templateType}', 'TemplateTypeController@update')
                ->name('api.template-types.update');
            // 删除
            $api->delete('template-types/{templateType}', 'TemplateTypeController@destroy')
                ->name('api.template-types.destroy');
            // 列表
            $api->get('template-types', 'TemplateTypeController@index')
                ->name('api.template-types.index');
            // 详情
            $api->get('template-types/{templateType}', 'TemplateTypeController@show')
                ->name('api.template-types.show');

            /**
             * 公共接口
             */
            // 图片上传
            $api->post('images/upload', 'ImageUploadHandlerController@upload')
                ->name('api.images.upload');
        });
    });
});
