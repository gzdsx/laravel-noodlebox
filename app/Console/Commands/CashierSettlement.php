<?php

namespace App\Console\Commands;

use App\Models\CashierTransaction;
use App\Models\Order;
use App\Models\PosMachine;
use Illuminate\Console\Command;

class CashierSettlement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cashier-settlement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $total = 0;
        $cash_total = 0;
        $online_total = 0;
        $card_total = 0;
        $refund_total = 0;
        $shipping_total = 0;
        $cash_profit_total = 0;

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

        $model = CashierTransaction::query()->whereDate('created_at', now())->firstOrNew();
        $model->total = $total;
        $model->shipping_total = $shipping_total;
        $model->cash_total = $cash_total;
        $model->online_total = $online_total;
        $model->card_total = $card_total;
        $model->refund_total = $refund_total;
        $model->cash_profit_total = $cash_total - $refund_total;
        $model->pos_base_amount = $pos_base_amount;
        $model->notes = now()->format('Y-m-d');
        $model->save();
        return 0;
    }
}
