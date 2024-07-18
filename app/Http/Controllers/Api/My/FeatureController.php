<?php

namespace App\Http\Controllers\Api\My;

use App\Models\Captcha;
use App\Models\User;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FeatureController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($request->filled('nickname')) {
            $nickname = $request->input('nickname');
            if ($nickname != $user->nickname) {
                $user->nickname = $nickname;
            }
        }

        if ($request->filled('avatar')) {
            $avatar = $request->input('avatar');
            if ($avatar != $user->avatar) {
                $user->avatar = $this->cropAvatar($avatar);
            }
        }

        if ($request->filled('national_number') && $request->filled('phone_number')) {
            $national_number = $request->input('national_number');
            $phone_number = $request->input('phone_number');
            $vercode = $request->input('vercode');

            if (!$this->checkVerificationCode($national_number, $phone_number, $vercode)) {
                return $this->error(trans('validation.custom.vercode.incorrect'));
            }

            if ($user->national_number != $national_number || $user->phone_number != $phone_number) {
                if (User::query()->where(compact('national_number', 'phone_number'))->exists()) {
                    return $this->error(trans('user.phone number has been taken'));
                }

                $user->national_number = $national_number;
                $user->phone_number = $phone_number;
            }
        }

        if ($request->filled('email')) {
            $email = $request->input('email');
            if ($user->email != $email) {
                if (User::query()->where('email', $email)->exists()) {
                    return $this->error(trans('user.email has been taken'));
                } else {
                    $user->email = $email;
                }
            }
        }

        $user->save();

        if ($request->filled('gender')) {
            $user->updateMeta('gender', $request->input('gender'));
        }

        if ($request->filled('birthday')) {
            $user->updateMeta('birthday', $request->input('birthday'));
        }

        if ($request->filled('bio')) {
            $user->updateMeta('bio', $request->input('bio'));
        }

        if ($request->filled('country')) {
            $user->updateMeta('country', $request->input('country'));
        }

        if ($request->filled('city')) {
            $user->updateMeta('city', $request->input('city'));
        }

        return json_success($user);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function cropAvatar($url)
    {
        $image = Image::make($url);
        if ($image->width() > $image->height()) {
            $width = $image->height();
        } else {
            $width = $image->width();
        }

        $image->crop($width, $width);

        if ($width > 500) {
            $image->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $path = 'image/' . Str::random(40) . '.png';
        $image->save(material_path($path), 100, 'png');
        return material_url($path);
    }

    protected function checkVerificationCode($national_number, $phone_number, $vercode)
    {
        return Captcha::checkPhone($national_number . ltrim($phone_number, '0'), $vercode);
    }
}
