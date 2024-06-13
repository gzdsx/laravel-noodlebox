<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LotteryController extends BaseController
{
    public function index()
    {

    }

    public function checkout(Request $request)
    {

        return view('web.lottery.checkout');
    }
}
