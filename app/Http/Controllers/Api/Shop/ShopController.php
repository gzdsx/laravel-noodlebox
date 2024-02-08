<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Traits\RestApis\ShopApis;
use Illuminate\Http\Request;

class ShopController extends BaseController
{
    use ShopApis;
}
