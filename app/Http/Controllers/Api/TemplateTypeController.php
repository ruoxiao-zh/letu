<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\TemplateTypeRequest;
use App\Models\TemplateType;
use App\Transformers\TemplateTypeTransformer;

class TemplateTypeController extends Controller
{
    public function store(TemplateTypeRequest $request, TemplateType $templateType)
    {
        $templateType->fill($request->all());
        $templateType->save();

        return $this->response->item($templateType, new TemplateTypeTransformer())
            ->setStatusCode(201);
    }

    public function update(TemplateTypeRequest $request, TemplateType $templateType)
    {
        $templateType->update($request->all());

        return $this->response->item($templateType, new TemplateTypeTransformer())
            ->setStatusCode(201);
    }

    public function destroy(Request $request, TemplateType $templateType)
    {
        $templateType->delete();

        return $this->response->noContent();
    }

    public function index(TemplateType $templateType)
    {
        $query = $templateType->query();
        $templateTypes = $query->orderBy('created_at', 'desc')->paginate();

        return $this->response->paginator($templateTypes, new TemplateTypeTransformer());
    }

    public function show(Request $request, TemplateType $templateType)
    {
        return $this->response->item($templateType, new TemplateTypeTransformer());
    }
}
