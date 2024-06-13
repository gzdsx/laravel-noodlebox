<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPhone;
use App\Models\Captcha;
use App\Models\WechatLogin;
use App\Traits\Auth\UserLogin;
use App\Traits\WeChat\WechatDefaultConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    use UserLogin, WechatDefaultConfig;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        session(['redirect' => $request->input('redirect', url()->previous())]);
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function appcode(Request $request)
    {

        if (!$basestr = session('basestr')) {
            $basestr = Str::uid()->toString();
            session(['basestr' => $basestr]);
        }

        WechatLogin::firstOrCreate(['basestr' => $basestr]);
        return $this->miniProgram()->app_code->getQrCode('/pages/auth/chklogin?basestr=' . $basestr, 140);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chklogin(Request $request)
    {
        if ($basestr = session('basestr')) {
            $login = WechatLogin::where('basestr', $basestr)->first();
            if ($login) {
                if ($login->id) {
                    Auth::loginUsingId($login->id);
                    $login->delete();
                    return json_success(['user' => Auth::user()]);
                }
            }
        }

        return json_success();
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
                $attributes = [
                    'phone_number' => $phone_number,
                    'national_number' => $national_number
                ];

                if (!$user = User::where($attributes)->first()) {
                    $user = new User();
                    $user->fill($attributes);
                    $user->nickname = $phone_number;
                    $user->save();
                }

                $user_phone = UserPhone::firstOrCreate($attributes)->firstOrNew();
                $user_phone->verified = 1;
                $user_phone->user()->associate($user);
                $user_phone->save();

                Auth::loginUsingId($user->id);

                return json_success();
            }

            return json_error(__('validation.custom.vercode.incorrect'), 422);
        }

        return json_error('code not found', 404, $address);
    }
}
