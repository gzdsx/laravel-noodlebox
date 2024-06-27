<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
            $orders = $deliveryer->orders;
            $base_amount = 0;
            foreach ($deliveryer->posMachines as $posMachine) {
                $base_amount += $posMachine->base_amount;
            }

            $shipping_total = 0;
            $cash_total = 0;
            $online_total = 0;
            $card_total = 0;
            $cost_total = 0;

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
            $transaction->total = ($base_amount + $cash_total + $cost_total) - $shipping_total;
            $transaction->notes = 'Settled at ' . now()->format('Y-m-d');
            $transaction->save();
        }

        return 0;
    }
}
