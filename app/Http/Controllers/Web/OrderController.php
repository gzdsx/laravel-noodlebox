<?php

namespace App\Http\Controllers\Web;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class OrderController extends Controller
{
    protected function repository()
    {
        return Auth::user()->boughts();
    }

    public function index(Request $request)
    {
        $orders = $this->repository()->paginate(10);

        return view('web.my-account.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = $this->repository()->findOrFail($id);

        return view('web.order', compact('order'));
    }
}
