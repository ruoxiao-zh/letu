<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\CaseRequest;
use App\Models\WxCase;
use App\Transformers\CaseTransformer;

class CaseController extends Controller
{
    public function store(CaseRequest $request, WxCase $case)
    {
        $case->fill($request->all());
        $case->save();

        return $this->response->item($case, new CaseTransformer())
            ->setStatusCode(201);
    }

    public function update(CaseRequest $request, WxCase $case)
    {
        $case->update($request->all());

        return $this->response->item($case, new CaseTransformer())
            ->setStatusCode(201);
    }

    public function destroy(Request $request, WxCase $case)
    {
        $case->delete();

        return $this->response->noContent();
    }

    public function index(WxCase $case)
    {
        $query = $case->query();
        $cases = $query->orderBy('created_at', 'desc')->paginate();

        return $this->response->paginator($cases, new CaseTransformer());
    }

    public function show(Request $request, WxCase $case)
    {
        return $this->response->item($case, new CaseTransformer());
    }
}
