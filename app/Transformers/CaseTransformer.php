<?php

namespace App\Transformers;

use App\Models\WxCase;
use League\Fractal\TransformerAbstract;

class CaseTransformer extends TransformerAbstract
{
    public function transform(WxCase $case)
    {
        return [
            'id' => $case->id,
            'name' => $case->name,
            'qr_code' => $case->qr_code,
            'created_at' => $case->created_at->toDateTimeString(),
            'updated_at' => $case->updated_at->toDateTimeString(),
        ];
    }
}
