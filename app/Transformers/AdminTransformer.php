<?php

namespace App\Transformers;

use App\Models\Admin;
use League\Fractal\TransformerAbstract;

class AdminTransformer extends TransformerAbstract
{
    public function transform(Admin $admin)
    {
        return [
            'id' => $admin->id,
            'name' => $admin->name,
            'created_at' => $admin->created_at->toDateTimeString(),
            'updated_at' => $admin->updated_at->toDateTimeString(),
        ];
    }
}
