<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Traits\RestApis\SoldApis;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    use SoldApis;

    public function batchDestroy(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        return json_success($request->input('ids', []));
    }

    public function statuses()
    {
        return json_success(trans('order.order_statuses'));
    }
}
