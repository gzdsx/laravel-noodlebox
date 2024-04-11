<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use App\Traits\RestApis\ShippingZoneApis;
use Illuminate\Http\Request;

class ShippingZoneController extends BaseController
{
    use ShippingZoneApis;
}
