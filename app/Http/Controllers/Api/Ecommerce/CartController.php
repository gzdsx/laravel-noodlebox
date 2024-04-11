<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Traits\RestApis\CartApis;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    use CartApis;
}
