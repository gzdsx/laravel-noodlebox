<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class CartController extends BaseController
{
    public function index()
    {

        return view('web.cart');
    }
}
