<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Traits\RestApis\SoldApis;
use Illuminate\Http\Request;

class SoldController extends BaseController
{
    use SoldApis;
}
