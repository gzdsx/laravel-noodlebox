<?php

namespace App\Listeners\Order;

use App\Events\OrderChanged;
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
     * @param  \App\Events\OrderChanged  $event
     * @return void
     */
    public function handle(OrderChanged $event)
    {
        //
    }
}
