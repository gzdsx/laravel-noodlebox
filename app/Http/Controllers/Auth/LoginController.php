<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Captcha;
use App\Models\User;
use App\Models\UserPhone;
use App\Providers\RouteServiceProvider;
use App\Traits\Auth\UserLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use UserLogin;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');
        parent::__construct($request);
    }

    public function index()
    {
        return view('auth.login');
    }

    public function loginWithSms(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
            'national_number' => 'required|numeric',
            'vercode' => 'required|numeric',
        ]);

        $code = $request->input('vercode');
        $phone_number = $request->input('phone_number', '');
        $national_number = $request->input('national_number', '353');

        $phone_number = preg_replace("/\s/", '', $phone_number);
        $address = $national_number . ltrim($phone_number, '0');
        if ($captcha = Captcha::wherePhone($address)->orderByDesc('id')->first()) {
            if ($code == $captcha->code) {
                if (substr($phone_number, 0, 1) != '0') {
                    $phone_number = '0' . $phone_number;
                }
                $attributes = [
                    'phone_number' => $phone_number,
                    'national_number' => $national_number
                ];

                if (!$user = User::where($attributes)->first()) {
                    $user = new User();
                    $user->fill($attributes);
                    $user->nickname = $user->phone_number;
                    $user->save();
                }

                $user_phone = UserPhone::firstOrCreate($attributes)->firstOrNew();
                $user_phone->verified_at = now();
                $user_phone->user()->associate($user);
                $user_phone->save();

                Auth::loginUsingId($user->id, $request->filled('remember'));

                return json_success();
            }

            return json_error(__('validation.custom.vercode.incorrect'), 422);
        }

        return json_error('code not found', 404, $address);
    }
}
