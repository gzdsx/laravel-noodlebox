<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends BaseController
{
    public function index(Request $request)
    {

        return view('web.checkout');
    }
}
