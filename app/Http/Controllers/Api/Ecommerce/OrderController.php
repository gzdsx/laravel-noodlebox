<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Traits\RestApis\OrderApis;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    use OrderApis;
}
