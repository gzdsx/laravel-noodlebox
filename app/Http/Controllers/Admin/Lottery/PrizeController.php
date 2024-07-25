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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $prize = $this->repository()->make();
        $prize->fill($request->all());
        $prize->save();
        return json_success($prize);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($id == 'batch'){
            $this->repository()->whereKey($request->input('ids', []))->update($request->input('data', []));
            return json_success();
        }else{
            $prize = $this->repository()->findOrFail($id);
            $prize->fill($request->all());
            $prize->save();
            return json_success($prize);
        }
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
