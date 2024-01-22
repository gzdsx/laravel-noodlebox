<?php

namespace App\Http\Controllers\Admin\Basic;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends BaseController
{
    /**
     * @return Link|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Link::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository()->where('type', $request->input('type', 'item'));
        if ($cate_id = $request->input('cate_id')) {
            $query->where('cate_id', $cate_id);
        }
        return json_success([
            'total' => $query->count(),
            'items' => $query->get()
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
        $model->fill($request->input('link', []))->save();
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
