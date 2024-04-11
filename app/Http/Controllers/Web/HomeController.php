<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index()
    {
        $navName = '';
        return view('web.home', compact('navName'));
    }
}
