<?php

namespace App\Console\Commands;

use App\Models\CashierTransaction;
use App\Models\Order;
use App\Models\PosMachine;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

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
        $cost_total = 0;

        $time_start = Carbon::createFromTimeString(settings('opening_hours_start'))->subDay();
        $time_end = Carbon::createFromTimeString(settings('opening_hours_end'));
        $orders = Order::whereBetween('created_at', [$time_start, $time_end])->get();
        foreach ($orders as $order) {
            $total += $order->total;
            $shipping_total += $order->shipping_total;
            $cost_total += $order->cost_total;

            if ($order->payment_method === 'cash') {
                $cash_total += $order->total;
            } elseif ($order->payment_method === 'online') {
                $online_total += $order->total;
            } elseif ($order->payment_method === 'card') {
                $card_total += $order->total;
            } elseif ($order->payment_method === 'customize') {
                $cash_total += $order->meta_data['payment_with_cash_value'] ?? 0;
                $card_total += $order->meta_data['payment_with_card_value'] ?? 0;
            }

            if ($order->refund_at) {
                $refund_total += $order->total;
            }
        }

        $base_amount = 0;
        $cashier_pos = PosMachine::where('is_cashier', 1)->first();
        if ($cashier_pos) {
            $base_amount = $cashier_pos->base_amount;
        }

        $model = CashierTransaction::query()->whereDate('created_at', now())->firstOrNew();
        $model->total = $total;
        $model->shipping_total = $shipping_total;
        $model->online_total = $online_total;
        $model->card_total = $card_total;
        $model->cash_total = $cash_total;
        $model->cost_total = $cost_total;
        $model->refund_total = $refund_total;
        $model->actual_total = ($cash_total + $cost_total - $refund_total - $shipping_total);
        $model->base_amount = $base_amount;
        $model->save();
        return 0;
    }
}
