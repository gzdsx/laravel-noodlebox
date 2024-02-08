<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Traits\RestApis\CategoryApis;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    use CategoryApis;
}
