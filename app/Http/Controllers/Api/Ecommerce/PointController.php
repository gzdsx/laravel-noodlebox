<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PointController extends BaseController
{
    public function purchase(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;

        $product = Product::findOrFail($product_id);
        if ($product->point_price * $quantity > $request->user()->points) {
            return json_error(__('Insufficient points balance'), 422);
        }

        return json_success();
    }
}
