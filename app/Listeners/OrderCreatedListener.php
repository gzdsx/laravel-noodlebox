<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Setting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        //发送短信
        if (settings('send_order_message') == 'yes') {
            try {
                $event->order->sendSms();
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }

        //打印订单
        if (settings('auto_print_order') == 'yes') {
            try {
                $event->order->printInvoice();
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }
    }
}
