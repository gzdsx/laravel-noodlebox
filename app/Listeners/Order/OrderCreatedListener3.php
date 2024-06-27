<?php

namespace App\Listeners\Order;

use App\Events\OrderCreated;
use App\Support\BulkSMS;
use App\Support\PrintNode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedListener3 implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param \App\Events\OrderCreated $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        dd(settings('send_order_message'));
        //发送短信
        if (settings('send_order_message') == 'yes') {
            $shipping = $event->order->shipping;
            if (isset($shipping['phone']) && is_array($shipping['phone'])) {
                if (is_array($shipping['phone'])) {
                    $phone_address = $shipping['phone']['national_number'] ?? '';
                    $phone_address .= $shipping['phone']['phone_number'] ?? '';
                } else {
                    $phone_address = $shipping['phone'];
                }

                BulkSMS::sendSms([
                    'from' => 'NoodleBox',
                    'to' => '+' . $phone_address,
                    'content' => settings('order_message_content')
                ]);
            }
        }

        //打印订单
        if (settings('auto_print_order') == 'yes') {
            PrintNode::createPrintJob([
                'printerId' => env('PRINTNODE_PRINTER_ID'),
                'title' => 'Invoice',
                'contentType' => 'pdf_uri',
                'content' => $event->order->links['invoice'],
                'source' => 'Noodlebox'
            ]);
        }
    }
}
