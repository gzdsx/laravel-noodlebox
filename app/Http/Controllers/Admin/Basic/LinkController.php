<?php

namespace App\Http\Controllers\Admin\Basic;


use App\Models\Link;
use App\Http\Controllers\Admin\BaseController;
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
            $this->repository()->whereKey($request->input('ids', []))->delete();
        } else {
            $this->repository()->whereKey($id)->delete();
        }

        return json_success();
    }
}
