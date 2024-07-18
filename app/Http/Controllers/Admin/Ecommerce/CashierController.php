<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Models\Order;
use App\Models\PosMachine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function calculate()
    {
        $total = 0;
        $cash_total = 0;
        $online_total = 0;
        $card_total = 0;
        $refund_total = 0;
        $shipping_total = 0;

        $orders = Order::where([])->get();
        foreach ($orders as $order) {
            $total += $order->total;
            $shipping_total += $order->shipping_total;

            if ($order->payment_method === 'cash') {
                $cash_total += $order->total;
            } elseif ($order->payment_method === 'online') {
                $online_total += $order->total;
            } elseif ($order->payment_method === 'card') {
                $card_total += $order->total;
            } elseif ($order->payment_method === 'customize') {
                $cash_total += $order->meta_data['payment_with_cash_value'] ?? 0;
            }

            if ($order->refund_at) {
                $refund_total += $order->total;
            }
        }

        $pos_base_amount = 0;
        $cashier_pos = PosMachine::where('is_cashier',1)->first();
        if ($cashier_pos){
            $pos_base_amount = $cashier_pos->base_amount;
        }

        $cash_profit_total = $cash_total;
        return json_success([
            'total'=>format_amount($total),
            'shipping_total'=>format_amount($shipping_total),
            'cash_total'=>format_amount($cash_total),
            'online_total'=>format_amount($online_total),
            'card_total'=>format_amount($card_total),
            'refund_total'=>format_amount($refund_total),
            'cash_profit_total'=>format_amount($cash_profit_total),
            'pos_base_amount'=>format_amount($pos_base_amount),
        ]);
    }
}
