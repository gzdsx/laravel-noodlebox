<?php

namespace App\Http\Controllers\H5;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('h5.index');
    }
}
