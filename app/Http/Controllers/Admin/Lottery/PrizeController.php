<?php

namespace App\Http\Controllers\Admin\Lottery;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Models\LotteryPrize;
use Illuminate\Http\Request;

class PrizeController extends BaseController
{
    protected function repository()
    {
        return LotteryPrize::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();
        return json_success([
            'count' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 20))
                ->get()
        ]);
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
    public function store(Request $request, $id = 0)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->input('prize', []));
        $model->save();
        return json_success($model);
    }

    public function batchUpdate(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->update($request->input('data', []));
        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        $this->repository()->whereKey($ids)->delete();
        return json_success();
    }
}
