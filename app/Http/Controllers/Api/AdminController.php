<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\AdminTransformer;
use App\Http\Requests\Api\AdminRequest;
use App\Models\Admin;

class AdminController extends Controller
{
    public function me()
    {
        return $this->response->item($this->user(), new AdminTransformer());
    }

    public function update(AdminRequest $request, Admin $admin)
    {
        $admin = $this->user();
        $attributes = $request->only(['name', 'password', 'email']);
        $admin->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        return $this->response->item($admin, new AdminTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('admin')->fromUser($admin),
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('admin')->factory()->getTTL() * 60
            ])
            ->setStatusCode(200);
    }

    public function store(AdminRequest $request)
    {
        $admin = Admin::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        return $this->response->item($admin, new AdminTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('admin')->fromUser($admin),
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('admin')->factory()->getTTL() * 60
            ])
            ->setStatusCode(201);
    }
}
