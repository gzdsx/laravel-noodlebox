<?php

namespace App\Http\Controllers\Admin\User;


use App\Http\Controllers\Admin\BaseController;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{

    /**
     * @return User|\Illuminate\Database\Eloquent\Builder
     */
    public function repository()
    {
        return User::query();
    }

    public function info(Request $request)
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
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 15);
        $query = $this->repository()->filter($request->all());
        return json_success([
            'total' => $query->count(),
            'items' => $query->with(['group', 'account'])->offset($offset)->limit($limit)->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id = null)
    {
        if ($id) {
            $model = $this->repository()->find($id);
        } else {
            $model = Auth::user();
        }
        $model->load('group');
        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id = null)
    {
        $newUser = collect($request->input('user', []));
        $model = $this->repository()->findOrNew($id);
        $isNewUser = !$model->uid;

        $nickname = $newUser->get('nickname');
        if ($model->nickname != $nickname) {
            if ($this->repository()->where('nickname', $nickname)->exists()) {
                return json_fail(trans('user.nickname has been taken'));
            } else {
                $model->nickname = $nickname;
            }
        }

        if ($password = $newUser->get('password')) {
            $model->password = bcrypt($password);
        }


        if ($phone = $newUser->get('phone')) {
            if ($model->phone != $phone) {
                if ($this->repository()->where('phone', $phone)->exists()) {
                    return json_fail(trans('user.mobile has been taken'));
                } else {
                    $model->phone = $phone;
                }
            }
        }


        if ($email = $newUser->get('email')) {
            if ($model->email != $email) {
                if ($this->repository()->where('email', $email)->exists()) {
                    return json_fail(trans('user.email has been taken'));
                } else {
                    $model->email = $email;
                }
            }
        }

        if ($gid = $newUser->get('gid')) {
            $model->gid = $gid;
        }

        if ($avatar = $newUser->get('avatar')) {
            $model->avatar = $avatar;
        }

        $model->save();

        if ($isNewUser) {
            event(new Registered($model));
        }

        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDelete(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->get()->map(function (User $user) {
            if (!$user->isAdmin()) {
                $user->delete();
            }
        });
        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchUpdate(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->get()->map(function (User $user) use ($request) {
            if ($user->isAdmin()) {
                $user->update($request->input('data', []));
            }
        });
        return json_success();
    }
}
