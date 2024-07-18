<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Models\Product;
use App\Traits\RestApis\CartApis;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    use CartApis;

    public function checkPotins(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;

        $product = Product::findOrFail($product_id);
        if ($product->points * $quantity > $request->user()->points) {
            abort(__('Insufficient points balance'), 422);
        }

        return json_success();
    }
}
