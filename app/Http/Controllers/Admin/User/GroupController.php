<?php

namespace App\Http\Controllers\Admin\User;


use App\Http\Controllers\Admin\BaseController;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class GroupController extends BaseController
{
    /**
     * @return UserGroup|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return UserGroup::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return json_success(['items' => $this->repository()->orderBy('credits')->get()]);
    }

    /**
     * @param Request $request
     * @param $gid
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $gid)
    {
        $model = $this->repository()->findOrNew($gid);
        $model->fill($request->input('group', []))->save();
        return json_success($model);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDestroy(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        return json_success();
    }
}
