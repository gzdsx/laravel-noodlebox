<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ApplePayController extends BaseController
{
    public function capture(Request $request)
    {
        $orderID = $request->input('orderID');
        $order = Order::findOrFail($orderID);
        if (!$order->isPaid()){
            $order->transaction_id = $request->input('merchantIdentifier');
            $order->markAsPaid();
        }

        return json_success();
    }
}
