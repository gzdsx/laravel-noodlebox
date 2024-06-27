<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyAccountController extends BaseController
{
    public function index(Request $request)
    {
        return view('web.my-account.orders', ['nav' => 'order']);
    }

    public function address(Request $request)
    {

        return view('web.my-account.address', ['nav' => 'address']);
    }

    public function points(Request $request)
    {
        return view('web.my-account.points', ['nav' => 'points']);
    }
}
