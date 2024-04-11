<?php

namespace App\Http\Controllers\Api\Basic;

use App\Http\Controllers\Api\BaseController;
use App\Models\Kefu;
use Illuminate\Http\Request;

class KefuController extends BaseController
{
    protected function repository()
    {
        return Kefu::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 15);
        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($offset)->limit($limit)->get()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id = 0)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->input('kefu', []))->save();

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
