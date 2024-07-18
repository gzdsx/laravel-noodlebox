<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Traits\RestApis\SoldApis;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;

class SoldController extends BaseController
{
    use SoldApis;
}
