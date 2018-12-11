<?php

namespace App\Transformers;

use App\Models\Agent;
use League\Fractal\TransformerAbstract;
use phpDocumentor\Reflection\Types\Boolean;

class AgentTransformer extends TransformerAbstract
{
    public function transform(Agent $agent)
    {
        return [
            'id' => $agent->id,
            'name' => $agent->name,
            'phone' => $agent->phone,
            'province' => $agent->province,
            'city' => $agent->city,
            'county' => $agent->county,
            'address' => $agent->address,
            'email' => $agent->email,
            'qq' => $agent->qq,
            'amount' => (int)$agent->amount,
            'money' => (double)$agent->money,
            'status' => (boolean)$agent->status,
            'created_at' => $agent->created_at->toDateTimeString(),
            'updated_at' => $agent->updated_at->toDateTimeString(),
        ];
    }
}
