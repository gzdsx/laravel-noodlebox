<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Traits\RestApis\ShippingZoneApis;
use Illuminate\Http\Request;

class ShippingZoneController extends BaseController
{
    use ShippingZoneApis;
}
