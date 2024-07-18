<?php

namespace App\Traits\RestApis;

use App\Models\Snippet;
use Illuminate\Http\Request;

trait SnippetApis
{
    /**
     * @return Snippet|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Snippet::query();
    }

    public function index(Request $request)
    {
        $query = $this->repository();

        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 15))
                ->get()
        ]);
    }

    public function show($id)
    {
        $model = $this->repository()->findOrNew($id);

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
            $this->repository()->whereKey($request->input('ids', []))->delete();
        } else {
            $this->repository()->whereKey($id)->delete();
        }
        return json_success();
    }
}