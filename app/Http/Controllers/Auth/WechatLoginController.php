<?php

namespace App\Http\Controllers\Auth;


use App\Models\WechatLogin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use function App\Http\Controllers\Auth\jsonError;

class WechatLoginController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $basestr = session('basestr');
        $wxlogin = WechatLogin::where('basestr', $basestr)->first();
        if ($wxlogin) {
            if ($wxlogin->id && $wxlogin->openid) {
                Auth::loginUsingId($wxlogin->id);
                session(['openid'=>$wxlogin->openid]);
                $wxlogin->delete();
                return json_success();
            }
        }

        return jsonError(401, 'unauthenticated!');
    }

    /**
     * @param Request $request
     * @return string|void
     */
    public function qrcode(Request $request)
    {
        $basestr = session('basestr');
        if (!$basestr) {
            $basestr = Str::uid()->toString();
            session(['basestr' => $basestr]);
            WechatLogin::create(['basestr' => $basestr]);
        }

        return QrCode::format('png')->size(500)->generate(url('h5/login?basestr=' . $basestr));
    }
}
