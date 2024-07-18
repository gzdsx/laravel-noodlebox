<?php

namespace App\Http\Controllers\Api\Auth;


use App\Models\User;
use App\Traits\Auth\UserRegister;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{

    use UserRegister;

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function registered(Request $request, User $user)
    {
        $access_token = $user->createToken('app')->accessToken;
        return json_success([
            'access_token' => $access_token
        ]);
    }
}
