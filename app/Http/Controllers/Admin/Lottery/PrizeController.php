<?php

namespace App\Http\Controllers\Admin\Lottery;

use App\Models\LotteryPrize;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
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
            'total' => $query->count(),
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

    public function update(Request $request, $id)
    {
        return $this->store($request, $id);
    }

    public function batchUpdate(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->update($request->input('data', []));
        return json_success();
    }

    public function destroy($id, Request $request)
    {
        if ($id == 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->delete();
        } else {
            $this->repository()->findOrFail($id)->delete();
        }
        return json_success();
    }
}
