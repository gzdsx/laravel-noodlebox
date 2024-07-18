<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use App\Models\UserPointTransaction;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
            'id' => $user->id,
            'nickname' => $user->nickname,
            'avatar' => $user->avatar,
            'email' => $user->email,
            'capability' => $user->getMeta('capability')
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
    public function store(Request $request)
    {
        $user = $this->repository()->make();
        $user->nickname = $request->input('nickname');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->filled('phone_number')) {
            $national_number = $request->input('national_number');
            $phone_number = $request->input('phone_number');

            if ($this->repository()->where(['national_number' => $national_number, 'phone_number' => $phone_number])->exists()) {
                abort(422, trans('user.phone number has been taken'));
            }

            $user->national_number = $national_number;
            $user->phone_number = $phone_number;
        }

        if ($request->filled('email')) {
            $email = $request->input('email');
            if ($this->repository()->where('email', $email)->exists()) {
                abort(422, trans('user.email has been taken'));
            } else {
                $user->email = $email;
            }
        }

        if ($request->filled('avatar')) {
            $user = $this->cropAvatar($request->input('avatar'));
        }

        $user->save();
        $user->refresh();

        if ($request->filled('meta_data')) {
            foreach ($request->input('meta_data', []) as $key => $value) {
                $user->updateMeta($key, $value);
            }
        }

        event(new Registered($user));

        return json_success();
    }

    public function update($id, Request $request)
    {
        if ($id == 'batch') {
            return $this->batchUpdate($request);
        }
        $user = $this->repository()->findOrFail($id);
        $user->nickname = $request->input('nickname');
        if ($request->filled('national_number') && $request->filled('phone_number')) {
            $national_number = $request->input('national_number');
            $phone_number = $request->input('phone_number');

            if ($user->national_number != $national_number || $user->phone_number != $phone_number) {
                if ($this->repository()->where(['national_number' => $national_number, 'phone_number' => $phone_number])->exists()) {
                    abort(422, trans('user.phone number has been taken'));
                }

                $user->national_number = $national_number;
                $user->phone_number = $phone_number;
            }
        }

        if ($request->filled('email')) {
            $email = $request->input('email');
            if ($user->email != $email) {
                if ($this->repository()->where('email', $email)->exists()) {
                    return json_error(trans('user.email has been taken'));
                } else {
                    $user->email = $email;
                }
            }
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->filled('avatar')) {
            $avatar = $request->input('avatar');
            if ($user->avatar != $avatar) {
                $user->avatar = $this->cropAvatar($avatar);
            }
        }

        $user->save();

        if ($request->filled('meta_data')) {
            foreach ($request->input('meta_data', []) as $key => $value) {
                $user->updateMeta($key, $value);
            }
        }

        return json_success($user);
    }

    public function destroy($id, Request $request)
    {
        if ($id == 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->get()->map(function (User $user) {
                if (!$user->isAdmin()) {
                    $user->delete();
                }
            });
        } else {
            $user = $this->repository()->findOrFail($id);
            if (!$user->isAdmin()) {
                $user->delete();
            }
        }
        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function batchUpdate(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->get()->map(function (User $user) use ($request) {
            $user->update($request->input('data', []));
        });
        return json_success();
    }

    public function updatePoints(Request $request, $id)
    {
        $user = $this->repository()->findOrFail($id);
        $action = $request->input('action');
        $amount = $request->input('amount');

        if ($amount > 0) {
            $transaction = new UserPointTransaction();
            $transaction->user_id = $user->id;
            $transaction->points = $amount;

            if ($action == 'add') {
                $user->points += $amount;
                $transaction->type = 1;
            } else {
                if ($user->points < $amount) {
                    $transaction->points = $user->points;
                    $user->points = 0;
                } else {
                    $user->points -= $amount;
                }
                $transaction->type = 2;
            }

            $transaction->save();
            $user->save();
        }
        return json_success();
    }

    public function options()
    {
        return json_success([
            'role_options' => trans('user.role_options'),
            'status_options' => trans('user.status_options'),
        ]);
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
}
