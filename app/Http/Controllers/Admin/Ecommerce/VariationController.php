<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Traits\RestApis\ProductVariationApis;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;

class VariationController extends BaseController
{
    use ProductVariationApis;
}
