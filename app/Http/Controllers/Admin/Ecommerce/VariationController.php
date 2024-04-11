<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Traits\RestApis\ProductVariationApis;
use Illuminate\Http\Request;

class VariationController extends BaseController
{
    use ProductVariationApis;
}
