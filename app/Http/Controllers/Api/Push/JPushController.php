<?php

namespace App\Http\Controllers\Api\Push;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JPushController extends BaseController
{
    public function index()
    {

    }

    public function register(Request $request)
    {

        return json_success();
    }
}
