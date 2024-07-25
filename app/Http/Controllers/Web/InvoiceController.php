<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CashierTransaction;
use App\Models\Deliveryer;
use App\Models\DeliveryerTransaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class InvoiceController extends BaseController
{
    public function order($id)
    {
        $order = Order::findOrFail($id);
        $order_items = $order->items()->with(['product'])->get();
        $order_items->each(function ($item) {
            $purchase_via = $item->meta_data['purchase_via'] ?? '';
            if ($purchase_via == 'lottery') {
                $item->sort_num = 10000;
            }elseif ($purchase_via == 'point'){
                $item->sort_num = 20000;
            } else {
                $item->sort_num = 0;
                if ($item->product) {
                    if ($first = $item->product->categories->first()) {
                        $item->sort_num = $first->sort_num;
                    }
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

        $order_items = $order_items->sortBy(function ($item){
            return $item->sort_num;
        });

        //return view('web.invoices.order', compact('order', 'order_items', 'subtotal'));

        $filename = 'invoice-' . $order->order_no . '@' . $order->created_at->format('His') . '.pdf';
        $pdf = \PDF::loadView('web.invoices.order', compact('order', 'order_items', 'subtotal'));
        //$pdf->setPaper('letter');
        $pdf->setOption('page-width', '80mm');
        $pdf->setOption('page-height', '3276mm');
        $pdf->setOption('disable-smart-shrinking', true);
        $pdf->setOption('margin-left', '4mm');
        $pdf->setOption('margin-right', '4mm');
        return $pdf->inline($filename);
    }

    public function cashierBilling($id)
    {
        $transaction = CashierTransaction::findOrFail($id);

        $filename = 'cashier-invoice-' . now()->format('His') . '.pdf';
        $pdf = \PDF::loadView('web.invoices.cashier-billing', compact('transaction'));
        //$pdf->setPaper('letter');
        $pdf->setOption('page-width', '80mm');
        $pdf->setOption('page-height', '3276mm');
        $pdf->setOption('disable-smart-shrinking', true);
        $pdf->setOption('margin-left', '4mm');
        $pdf->setOption('margin-right', '4mm');
        return $pdf->inline($filename);

        //return view('web.invoices.cashier-billing', compact('transaction'));
    }

    public function DeliveryerBilling($id)
    {
        $deliveryer = Deliveryer::findOrFail($id);
        $transaction = $deliveryer->generateTransaction();
        $transaction->created_at = now();

        $filename = 'deliveryer-invoice-' . now()->format('His') . '.pdf';
        $pdf = \PDF::loadView('web.invoices.deliveryer-billing', compact('transaction'));
        //$pdf->setPaper('letter');
        $pdf->setOption('page-width', '80mm');
        $pdf->setOption('page-height', '3276mm');
        $pdf->setOption('disable-smart-shrinking', true);
        $pdf->setOption('margin-left', '4mm');
        $pdf->setOption('margin-right', '4mm');
        return $pdf->inline($filename);
    }

    public function cashierTransaction($id)
    {
        $transaction = CashierTransaction::findOrFail($id);
        $filename = 'cashier-invoice-' . now()->format('His') . '.pdf';
        $pdf = \PDF::loadView('web.invoices.cashier-billing', compact('transaction'));
        //$pdf->setPaper('letter');
        $pdf->setOption('page-width', '80mm');
        $pdf->setOption('page-height', '3276mm');
        $pdf->setOption('disable-smart-shrinking', true);
        $pdf->setOption('margin-left', '4mm');
        $pdf->setOption('margin-right', '4mm');
        return $pdf->inline($filename);
    }

    public function deliveryerTransaction($id)
    {
        $transaction = DeliveryerTransaction::findOrFail($id);
        $filename = 'deliveryer-invoice-' . now()->format('His') . '.pdf';
        $pdf = \PDF::loadView('web.invoices.deliveryer-billing', compact('transaction'));
        //$pdf->setPaper('letter');
        $pdf->setOption('page-width', '80mm');
        $pdf->setOption('page-height', '3276mm');
        $pdf->setOption('disable-smart-shrinking', true);
        $pdf->setOption('margin-left', '4mm');
        $pdf->setOption('margin-right', '4mm');
        return $pdf->inline($filename);
    }
}
