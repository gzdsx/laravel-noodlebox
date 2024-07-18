<?php

namespace App\Http\Controllers\Api\Auth;


use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Dypnsapi\Dypnsapi;
use App\Models\User;
use App\Http\Controllers\Api\BaseController;
use EasyWeChat\Kernel\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NumberController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function index(Request $request)
    {
        AlibabaCloud::accessKeyClient(env('ALIYUN_ACCESS_KEY_ID'), env('ALIYUN_ACCESS_SECRET'))->asDefaultClient();
        $token = $request->input('token');
        try {
            $api = Dypnsapi::v20170525()->getMobile();
            $result = $api
                ->withAccessToken($token)
                ->debug(false) // Enable the debug will output detailed information
                ->request()->toArray();

            if (isset($result['GetMobileResultDTO'])) {
                $phone = $result['GetMobileResultDTO']['Mobile'] ?? null;
                if ($phone) {
                    $user = User::where('phone', $phone)->firstOrNew();
                    if (!$user->phone) {
                        $user->phone = $phone;
                    }

                    if (!$user->nickname) {
                        $user->nickname = 'user_' . Str::random(10);
                    }

                    $user->save();

                    return json_success(['access_token' => $user->createToken('')->accessToken]);
                }
            }

            return json_error($result['Message']);
        } catch (Exception $exception) {
            return json_error($exception->getMessage());
        }
    }
}
