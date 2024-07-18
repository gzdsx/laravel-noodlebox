<?php

namespace App\Http\Controllers\Api\Lottery;

use App\Models\LotteryPrize;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrizeController extends BaseController
{
    protected function repository()
    {
        return LotteryPrize::withGlobalScope('avalaible', function ($builder) {
            return $builder->where('stock', '>', 0)->where('status', 1);
        });
    }

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

    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
    }
}
