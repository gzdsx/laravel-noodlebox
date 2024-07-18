<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Traits\RestApis\ProductAttributeApis;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;

class AttributeController extends BaseController
{
    use ProductAttributeApis;
}
