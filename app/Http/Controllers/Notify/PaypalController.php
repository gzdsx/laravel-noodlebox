<?php

namespace App\Http\Controllers\Notify;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaypalEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    public function webhooks(Request $request)
    {
        Log::channel('paypal')->debug($request->getContent());

        $data = json_decode($request->getContent());
        $event = new PaypalEvent();
        $event->data = $data;
        $event->save();

        //更新订单状态
        if ($data->event_type == 'CHECKOUT.ORDER.APPROVED') {
            $order = Order::whereTransactionId($data->resource->id)->first();
            if ($order && !$order->isPaid()) {
                $order->markAsPaid();
            }
        }
    }
}
