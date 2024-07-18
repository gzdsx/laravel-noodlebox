<?php

namespace App\Http\Controllers\Admin\Category;

use App\Traits\RestApis\CategoryApis;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;

class CategoryController extends BaseController
{
    use CategoryApis;
}
