<?php

namespace App\Http\Controllers\Notify;

use App\Http\Controllers\Controller;
use App\Models\PaypalEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    public function webhooks(Request $request)
    {
        Log::channel('paypal')->debug($request->getContent());

        $event = new PaypalEvent();
        $event->data = json_decode($request->getContent());
        $event->save();
    }
}
