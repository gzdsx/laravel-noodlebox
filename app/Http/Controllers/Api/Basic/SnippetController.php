<?php

namespace App\Http\Controllers\Api\Basic;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Snippet;
use App\Traits\RestApis\SnippetApis;
use Illuminate\Http\Request;

class SnippetController extends BaseController
{
    use SnippetApis;
}
