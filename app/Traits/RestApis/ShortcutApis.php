<?php

namespace App\Traits\RestApis;

use App\Models\Shortcut;
use Illuminate\Http\Request;

trait ShortcutApis
{
    /**
     * @return Shortcut|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Shortcut::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        $query = $this->repository()->whereType($type);

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
        $model = $this->repository()->findOrFail($id);

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
        $model->fill($request->input('shortcut', []))->save();

        return json_success($model);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->repository()->whereKey($id)->delete();
        return json_success();
    }
}