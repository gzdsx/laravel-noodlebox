<?php

namespace App\Traits\RestApis;

use App\Models\Block;
use Illuminate\Http\Request;

trait BlockApis
{
    /**
     * @return Block|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Block::query();
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
        $model = $this->repository()->findOrNew($id);
        $model->load('items');
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

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->all())->save();
        return json_success($model);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        } else {
            $this->repository()->findOrFail($id)->delete();
        }

        return json_success();
    }
}