<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends BaseController
{
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
            'email' => $user->email
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(Request $request)
    {
        $model = Auth::user();
        $model->avatar = $request->input('avatar');
        $model->save();

        return json_success($model->avatar);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateName(Request $request)
    {
        $name = $request->input('name');
        $model = Auth::user();

        if ($name != $model->name) {
            $model->name = $name;
            $model->save();
        }

        return json_success($name);
    }
}
