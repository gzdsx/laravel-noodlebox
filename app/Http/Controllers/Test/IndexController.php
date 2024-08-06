<?php

namespace App\Http\Controllers\Test;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\SystemNotification;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $order = Order::find(297);

        event(new OrderCreated($order));

        $user = User::find(1000080);
        $user->notifyNow(new SystemNotification('wlerklsdjfklsdjdkljkdl'));
    }

    public function table(Request $request)
    {
        $table = $request->input('t');
        return str_replace('"', "'", json_encode(Schema::getColumnListing($table)));
    }
}
