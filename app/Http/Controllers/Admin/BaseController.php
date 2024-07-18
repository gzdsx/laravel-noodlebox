<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api');
        $this->middleware(function (Request $req, $next) {
            if (!Auth::check()) {
                if ($req->expectsJson()) {
                    throw new AuthenticationException();
                }
                return redirect()->to(admin_url('login?redirect=' . url()->current()));
            }

            $capability = $req->user()->getMeta('capability');
            if (!in_array($capability, ['administrator', 'manager'])) {
                abort(403, '你没有此项权限');
            }

            return $next($req);
        });
    }
}
