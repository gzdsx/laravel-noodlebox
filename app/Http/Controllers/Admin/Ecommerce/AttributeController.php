<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Traits\RestApis\ProductAttributeApis;
use Illuminate\Http\Request;

class AttributeController extends BaseController
{
    use ProductAttributeApis;
}
