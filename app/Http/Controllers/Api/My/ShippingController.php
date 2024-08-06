<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingController extends BaseController
{
    public function index()
    {
        $user = Auth::user();
        return json_success([
            'shipping_method' => $user->getMeta('shipping_method', ''),
            'shipping_zone_id' => $user->getMeta('shipping_zone_id', ''),
            'shipping_zone_name' => $user->getMeta('shipping_zone_name', ''),
            'shipping_address' => $user->getMeta('shipping_address', [])
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($request->filled('shipping_method')) {
            $user->updateMeta('shipping_method', $request->input('shipping_method'));
        }

        if ($request->filled('shipping_zone_id')) {
            $user->updateMeta('shipping_zone_id', $request->input('shipping_zone_id'));
        }

        if ($request->filled('shipping_zone_name')) {
            $user->updateMeta('shipping_zone_name', $request->input('shipping_zone_name'));
        }

        if ($request->filled('shipping_address')) {
            $user->updateMeta('shipping_address', $request->input('shipping_address'));
        }

        return json_success();
    }
}
