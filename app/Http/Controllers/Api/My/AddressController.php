<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Traits\RestApis\UserAddressApis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends BaseController
{
    public function index()
    {
        $user = Auth::user();
        return json_success([
            'shipping' => $user->getMeta('shipping_address'),
            'billing' => $user->getMeta('billing_address')
        ]);
    }

    public function store(Request $request)
    {

    }
}
