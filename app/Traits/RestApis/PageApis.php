<?php

namespace App\Traits\RestApis;

use App\Models\Page;
use Illuminate\Http\Request;

trait PageApis
{
    /**
     * @return Page|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Page::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();
        $total = $query->count();
        $items = $query->get();

        return json_success(['items' => $items, 'total' => $total]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->findOrNew($id);
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
        $model->fill($request->input('page', []));
        $model->save();
        return json_success($model);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDestroy(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->delete();
        return json_success();
    }
}