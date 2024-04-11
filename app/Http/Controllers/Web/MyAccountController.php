<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyAccountController extends BaseController
{
    public function index(Request $request)
    {
        $my = $request->user();
        return view('web.my-account.index', compact('my'));
    }
}
