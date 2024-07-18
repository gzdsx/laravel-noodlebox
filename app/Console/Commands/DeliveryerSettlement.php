<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeliveryerSettlement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deliveryer-settlement';

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
        $deliveryers = \App\Models\Deliveryer::all();
        foreach ($deliveryers as $deliveryer) {

            $base_amount = $deliveryer->base_amount;
//            foreach ($deliveryer->posMachines as $posMachine) {
//                $base_amount += $posMachine->base_amount;
//            }

            $shipping_total = 0;
            $cash_total = 0;
            $online_total = 0;
            $card_total = 0;
            $cost_total = 0;

            $time_start = Carbon::createFromTimeString(settings('opening_hours_start'))->subDay();
            $time_end = Carbon::createFromTimeString(settings('opening_hours_end'));
            $orders = $deliveryer->orders()->whereBetween('created_at', [$time_start, $time_end])->get();
            foreach ($orders as $order) {
                $shipping_total += $order->shipping_total;
                if ($order->payment_method == 'cash') {
                    $cash_total += $order->total;
                }

                if ($order->payment_method == 'online') {
                    $online_total += $order->total;
                }

                if ($order->payment_method == 'card') {
                    $card_total += $order->total;
                }

                if ($amount = $order->getMeta('cost_total')) {
                    $cost_total += $amount;
                }
            }

            $transaction = $deliveryer->transactions()->whereDate('created_at', now())->firstOrNew();
            $transaction->base_amount = $base_amount;
            $transaction->shipping_total = $shipping_total;
            $transaction->cash_total = $cash_total;
            $transaction->online_total = $online_total;
            $transaction->card_total = $card_total;
            $transaction->cost_total = $cost_total;
            $transaction->total = ($cash_total + $cost_total) - $shipping_total;
            $transaction->save();
        }

        return 0;
    }
}
