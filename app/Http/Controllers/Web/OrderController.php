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

        $order_items = $order->items()->with(['product'])->get();
        $order_items->each(function ($item) {
            if (isset($item->meta_data['purchase_via']) && $item->meta_data['purchase_via'] == 'lottery') {
                $item->sort_num = 10000;
            } else {
                if ($item->product) {
                    if ($first = $item->product->categories->first()) {
                        $item->sort_num = $first->sort_num;
                    } else {
                        $item->sort_num = 0;
                    }
                } else {
                    $item->sort_num = 0;
                }
            }
        });

        //dd($order_items->toArray());

//        $order_items->sort(function ($a, $b) {
//            return $b->sort_num - $a->sort_num;
//        });

        $subtotal = $order_items->reduce(function ($carry, $item) {
            return $carry + $item->price * $item->quantity;
        }, 0);

//        $order_items = $order_items->toArray();
//        usort($order_items, function ($a, $b) {
//            return $b['sort_num'] - $a['sort_num'];
//        });

        $order_items = $order_items->sortBy('sort_num');

        //return view('web.invoice', compact('order', 'order_items', 'subtotal'));

        $filename = 'invoice-' . $order->order_no . '@' . $order->created_at->format('His') . '.pdf';
        $pdf = \PDF::loadView('web.invoice', compact('order', 'order_items', 'subtotal'));
        //$pdf->setPaper('letter');
        $pdf->setOption('page-width', '80mm');
        $pdf->setOption('page-height', '3276mm');
        $pdf->setOption('disable-smart-shrinking', true);
        $pdf->setOption('margin-left', '4mm');
        $pdf->setOption('margin-right', '4mm');
        return $pdf->inline($filename);
    }
}
