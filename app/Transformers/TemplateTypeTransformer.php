<?php

namespace App\Transformers;

use App\Models\TemplateType;
use League\Fractal\TransformerAbstract;

class TemplateTypeTransformer extends TransformerAbstract
{
    public function transform(TemplateType $templateType)
    {
        return [
            'id' => $templateType->id,
            'name' => $templateType->name,
            'introduce' => $templateType->introduce,
            'logo' => $templateType->logo,
            'detail_picture' => $templateType->detail_picture,
            'created_at' => $templateType->created_at->toDateTimeString(),
            'updated_at' => $templateType->updated_at->toDateTimeString(),
        ];
    }
}
