<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Models\Order;
use App\Traits\RestApis\OrderApis;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    use OrderApis;

    protected function repository()
    {
        return Order::query();
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

    public function printOrder($id)
    {
        $order = $this->repository()->findOrFail($id);
        $order->printInvoice();
    }
}
