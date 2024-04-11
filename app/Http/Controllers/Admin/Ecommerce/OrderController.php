<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Traits\RestApis\SoldApis;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    use SoldApis;
}
