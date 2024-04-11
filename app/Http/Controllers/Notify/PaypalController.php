<?php

namespace App\Http\Controllers\Notify;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    public function webhooks(Request $request)
    {
        Log::channel('paypal')->debug($request->getContent());
    }
}
