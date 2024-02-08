<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * @return Product|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Product::query();
    }

    public function index(Request $request)
    {

    }

    public function show($slug)
    {
        $product = get_product($slug);
        if (!$product || !$product->isOnSale()) {
            abort(404, trans('product.this product has been removed'));
        }
        return view('web.single-product', compact('product'));
    }
}
