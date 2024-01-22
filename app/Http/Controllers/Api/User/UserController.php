<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Api\BaseController;
use App\Models\UserFans;
use App\Traits\RestApis\UserApis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends BaseController
{

    use UserApis;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        $user = Auth::user();
        return json_success([
            'uid' => $user->uid,
            'nickname' => $user->nickname,
            'avatar' => $user->avatar,
            'phone' => $user->phone,
            'email' => $user->email,
            'gender' => $user->getMeta('gender'),
            'provice' => $user->getMeta('province'),
            'city' => $user->getMeta('province')
        ]);
    }


    public function getList(Request $request)
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Request $request)
    {
        $fans = UserFans::firstOrCreate([
            'uid' => $request->input('uid'),
            'fans_id' => Auth::id()
        ]);

        return json_success(['fans' => $fans]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unfollow(Request $request)
    {
        $fans = UserFans::where([
            'uid' => $request->input('uid'),
            'fans_id' => Auth::id()
        ])->first();

        if ($fans) {
            $fans->delete();
        }

        return json_success();
    }
}
