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
        $items = $query->offset($request->input('offset', 0))
            ->limit($request->input('limit', 15))
            ->orderBy('sort_num')
            ->get();

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $model = $this->repository()->make();
        $model->fill($request->all());
        $model->save();
        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->all());
        $model->save();
        return json_success($model);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'batch'){
            $this->repository()->whereKey($request->input('ids', []))->delete();
        }else{
            $this->repository()->findOrFail($id)->delete();
        }
        return json_success();
    }
}