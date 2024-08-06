<?php

namespace App\Http\Controllers\Web;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function export()
    {
        return (new ProductsExport())->download('products.xlsx');
    }
}
