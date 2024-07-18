<?php

namespace App\Http\Controllers\Admin\Basic;

use App\Models\Snippet;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SnippetController extends BaseController
{
    /**
     * @return Snippet|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Snippet::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return json_success([
            'total' => $this->repository()->count(),
            'items' => $this->repository()
                ->offset($request->input('offset', 0))
                ->limit($request->input('limit', 15))->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->find($id);
        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id = null)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->input('snippet', []))->save();
        return json_success($model);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function batchDestroy(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->delete();
        return json_success();
    }
}
