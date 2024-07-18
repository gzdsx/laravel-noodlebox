<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class CustomEnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     * @param null $redirectToRoute
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        if ($request->user() && $request->user()->email) {
            if ($request->user() instanceof MustVerifyEmail && !$request->user()->hasVerifiedEmail()) {
                return $request->expectsJson()
                    ? abort(403, 'Your email address is not verified.')
                    : Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
            }
        }

        if ($request->user() && $request->user()->freeze) {
            //return abort(403, 'Your account has been restricted from logging in. Please contact the administrator.');
            return $request->expectsJson()
                ? abort(403, 'Your account has been restricted from logging in. Please contact the administrator.')
                : Redirect::guest(URL::route('verification.forbidden'));
        }

        return $next($request);
    }
}
