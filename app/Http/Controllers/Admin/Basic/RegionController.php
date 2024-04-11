<?php

namespace App\Http\Controllers\Admin\Basic;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends BaseController
{
    /**
     * @return Region|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Region::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository()->where('parent_id', $request->input('parent_id', 0));

        return json_success([
            'total' => $query->count(),
            'items' => $query->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->findOrNew($id);
        $model->load(['ancestor']);
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
        $model->fill($request->input('region', []));
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
