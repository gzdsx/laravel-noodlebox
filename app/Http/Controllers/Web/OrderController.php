<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
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

    public function invoice($hashid)
    {
        $id = Hashids::decodeHex($hashid);
        $order = Order::findOrFail($id);

        $filename = 'invoice-' . $order->order_no . '@' . $order->created_at->format('His') . '.pdf';
        $pdf = \PDF::loadView('web.invoice', compact('order'));
        $pdf->setOption('page-width', '142mm');
        $pdf->setOption('page-height', '460mm');
        $pdf->setOption('disable-smart-shrinking', true);
        $pdf->setOption('margin-left', '4mm');
        $pdf->setOption('margin-right', '4mm');
        return $pdf->inline($filename);
    }
}
