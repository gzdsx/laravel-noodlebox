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

    /**
     * @param Request $request
     * @param $order_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function notes(Request $request, $order_id)
    {
        $order = $this->repository()->findOrFail($order_id);
        $query = $order->notes();
        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 10))
                ->orderByDesc('created_at')->get()
        ]);
    }
}
