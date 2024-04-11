<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Traits\RestApis\UserGroupApis;
use Illuminate\Http\Request;

class GroupController extends BaseController
{
    use UserGroupApis;
}
