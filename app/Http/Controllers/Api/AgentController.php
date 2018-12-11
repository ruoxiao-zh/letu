<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\AgentRequest;
use App\Models\Agent;
use App\Transformers\AgentTransformer;
use Overtrue\EasySms\EasySms;
use Carbon\Carbon;
use App\Http\Requests\Api\VerificationCodeRequest;

class AgentController extends Controller
{
    public function store(AgentRequest $request, Agent $agent)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回 401
            return $this->response->errorUnauthorized('验证码错误');
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $agent->fill($data);
        $agent->save();

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return $this->response->item($agent, new AgentTransformer())
            ->setStatusCode(201);
    }

    public function update(AgentRequest $request, Agent $agent)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $agent->update($data);

        return $this->response->item($agent, new AgentTransformer());
    }

    public function destroy(Request $request, Agent $agent)
    {
        $agent->delete();

        return $this->response->noContent();
    }

    public function index(Request $request, Agent $agent)
    {
        $query = $agent->query();
        $agents = $query
            ->when($request->city, function ($query) use ($request) {
                return $query->whereCity($request->city);
            })
            ->when($request->phone, function ($query) use ($request) {
                return $query->whereName($request->phone);
            })
            ->when($request->name, function ($query) use ($request) {
                return $query->whereName($request->name);
            })
            ->when($request->status, function ($query) use ($request) {
                return $query->whereStatus($request->status);
            })
            ->when($request->begin_time, function ($query) use ($request) {
                return $query->where('created_at', '>=', $request->begin_time);
            })
            ->when($request->end_time, function ($query) use ($request) {
                return $query->where('updated_at', '<=', $request->end_time);
            })
            ->orderBy('created_at', 'desc')->paginate();

        return $this->response->paginator($agents, new AgentTransformer());
    }

    public function show(Request $request, Agent $agent)
    {
        return $this->response->item($agent, new AgentTransformer());
    }

    public function startOrForbidden(Request $request, Agent $agent)
    {
        if ($agent->status) {
            $agent->status = 0;
        } else {
            $agent->status = 1;
        }
        $agent->save();

        return $this->response->item($agent, new AgentTransformer());
    }

    public function sendMessage(VerificationCodeRequest $request, EasySms $easySms)
    {
        // 生成 4 位随机数，左侧补 0
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        // 发送短信
        try {
            $easySms->send($request->phone, [
                'template' => env('ALIYUN_AGENT_REGISETER_TEMPLATE', ''),
                'data' => [
                    'code' => $code
                ],
            ]);
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            $message = $exception->getException('aliyun')->getMessage();

            return $this->response->errorInternal($message ?? '短信发送异常');
        }

        $key = 'verificationCode_' . str_random(15);
        $expiredAt = Carbon::now()->addMinutes(10);
        // 缓存验证码 10分钟过期。
        \Cache::put($key, ['phone' => $request->phone, 'code' => $code], $expiredAt);

        return $this->response->array([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
