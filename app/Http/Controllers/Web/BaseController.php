<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(function ($request, $next) {
            \View::share([
                'my' => $request->user()
            ]);
            return $next($request);
        });
    }
}
