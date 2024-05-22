<?php

namespace App\Http\Controllers\Admin\Lottery;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Models\LotteryRecord;
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
            'count' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 20))
                ->get()
        ]);
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
