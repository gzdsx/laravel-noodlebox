<?php

namespace App\Http\Controllers\Api\Lottery;

use App\Models\LotteryCart;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    protected function repository()
    {
        return LotteryCart::withGlobalScope('owner', function ($builder) {
            return $builder->where('user_id', auth()->id());
        });
    }

    public function index(Request $request)
    {
        $query = $this->repository();
        return json_success([
            'count' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 20))
                ->orderByDesc('id')
                ->get()
        ]);
    }
}
