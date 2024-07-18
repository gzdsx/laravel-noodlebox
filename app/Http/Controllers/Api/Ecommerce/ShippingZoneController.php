<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Traits\RestApis\ShippingZoneApis;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;

class ShippingZoneController extends BaseController
{
    use ShippingZoneApis;
}
