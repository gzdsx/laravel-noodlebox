<?php

namespace App\Http\Controllers\Api\User;


use App\Traits\RestApis\UserApis;
use App\Http\Controllers\Api\BaseController;
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
            'id' => $user->id,
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
            'id' => $request->input('id'),
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
            'id' => $request->input('id'),
            'fans_id' => Auth::id()
        ])->first();

        if ($fans) {
            $fans->delete();
        }

        return json_success();
    }
}
