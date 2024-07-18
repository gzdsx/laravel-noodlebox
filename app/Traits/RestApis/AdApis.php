<?php

namespace App\Traits\RestApis;

use App\Models\Ad;
use Illuminate\Http\Request;

trait AdApis
{
    /**
     * @return Ad|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Ad::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 15);
        $query = $this->repository();
        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($offset)->limit($limit)->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
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

    public function update(Request $request, $id)
    {
        if ($id == 'batch'){
            $this->repository()->whereKey($request->input('ids', []))->update($request->input('data', []));
            return json_success();
        }

        $model = $this->repository()->findOrNew($id);
        $model->fill($request->all())->save();
        return json_success($model);
    }

    public function destroy($id, Request $request)
    {
        if ($id == 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->delete();
            return json_success();
        } else {
            $this->repository()->whereKey($id)->delete();
        }
        return json_success();
    }
}