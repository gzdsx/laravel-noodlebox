<?php

namespace App\Http\Controllers\Admin\Basic;

use App\Models\Kefu;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;

class KefuController extends BaseController
{
    protected function repository()
    {
        return Kefu::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 15);
        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($offset)->limit($limit)->get()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $model = $this->repository()->make();
        $model->fill($request->all())->save();

        return json_success($model);
    }

    public function show($id)
    {
        $model = $this->repository()->findOrNew($id);
        return json_success($model);
    }

    public function destroy($id, Request $request)
    {
        if ($id == 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->delete();
        } else {
            $this->repository()->whereKey($id)->delete();
        }

        return json_success();
    }

    public function update(Request $request, $id)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->all())->save();

        return json_success($model);
    }
}
