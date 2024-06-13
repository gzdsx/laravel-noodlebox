<?php

namespace App\Listeners\Order;

use App\Events\OrderChanged;
use App\Models\OrderNote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderChangedListener
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
     * @param \App\Events\OrderChanged $event
     * @return void
     */
    public function handle(OrderChanged $event)
    {
        $order = $event->order;

        if ($event->eventType == 'created') {
            $note = new OrderNote();
            $note->order_id = $order->id;
            $note->user_id = $order->buyer_id;
            $note->content = 'Order created via ' . $order->created_via;
            $note->save();
        }
    }
}
