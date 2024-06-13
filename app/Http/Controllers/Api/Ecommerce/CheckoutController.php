<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends BaseController
{
    public function settings()
    {
        return json_success([
            'currency' => settings('currency', 'EUR'),
            'currency_symbol' => settings('currency_symbol', '$'),
            'currency_position' => settings('currency_position', 'left'),
            'tax_rate' => settings('tax_rate', 0),
            'tax_type' => settings('tax_type', 'exclusive'),
            'shipping_type' => settings('shipping_type', 'flat_rate'),
            'shipping_flat_rate' => settings('shipping_flat_rate', 0),
            'shipping_free_shipping' => settings('shipping_free_shipping', 0),
            'enable_points_checkout' => settings('enable_points_checkout', 'no')
        ]);
    }
}
