<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
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

        $sort_array = [];
        $products = Product::whereKey($order->items->pluck('product_id'))->get();
        foreach ($products as $product) {
            if (isset($product->categories[0])) {
                $sort_array[$product->id] = $product->categories[0]['sort_num'] ?? 0;
            } else {
                $sort_array[$product->id] = 0;
            }
        }

        $order_items = [];
        foreach ($order->items as $item) {
            if (isset($sort_array[$item->product_id])) {
                $item->sort_num = $sort_array[$item->product_id];
            } else {
                $item->sort_num = 0;
            }

            $order_items[] = $item;
        }

        usort($order_items, function ($a, $b) {
            return $a->sort_num - $b->sort_num;
        });

        $subtotal = array_reduce($order_items, function ($carry, $item) {
            return $carry + $item->price * $item->quantity;
        }, 0);

        //return view('web.invoice', compact('order', 'order_items', 'subtotal'));

        $filename = 'invoice-' . $order->order_no . '@' . $order->created_at->format('His') . '.pdf';
        $pdf = \PDF::loadView('web.invoice', compact('order', 'order_items', 'subtotal'));
        $pdf->setOption('page-width', '142mm');
        $pdf->setOption('page-height', '460mm');
        $pdf->setOption('disable-smart-shrinking', true);
        $pdf->setOption('margin-left', '4mm');
        $pdf->setOption('margin-right', '4mm');
        return $pdf->inline($filename);
    }
}
