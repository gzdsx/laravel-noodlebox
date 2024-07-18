<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends BaseController
{
    public function index()
    {
        $user = Auth::user();
        $address = array_merge([
            'id' => 0,
            'first_name' => '',
            'last_name' => '',
            'address_line_1' => '',
            'address_line_2' => '',
            'city' => '',
            'state' => '',
            'country' => '',
            'postal_code' => '',
            'natinal_number' => '353',
            'phone_number' => ''
        ], $user->getMeta('shipping_address', []));
        return json_success([
            'shipping' => $address,
            'billing' => $address
        ]);
    }

    public function store(Request $request)
    {
        $request->user()->updateMeta('shipping_address', $request->all());
        return json_success();
    }
}
