<?php

namespace App\Http\Controllers\Admin\Lottery;

use App\Models\LotteryRecord;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecordController extends BaseController
{
    /**
     * @return LotteryRecord|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository(){
        return LotteryRecord::query();
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
                ->limit($request->input('limit', 15))
                ->orderByDesc('id')
                ->get()
        ]);
    }

    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
    }

    public function store(Request $request, $id = 0)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->all());
        $model->save();
        return json_success($model);
    }

    public function update($id)
    {

    }

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
