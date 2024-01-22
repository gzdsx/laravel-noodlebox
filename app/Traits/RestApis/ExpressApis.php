<?php

namespace App\Traits\RestApis;

use App\Models\Express;
use Illuminate\Http\Request;

trait ExpressApis
{
    /**
     * @return Express|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Express::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return json_success(['items' => $this->repository()->get()]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id = null)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->input('express', []))->save();
        return json_success($model);
    }

    /**
     * @param Request $request
     */
    public function batchDestroy(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->delete();
    }
}