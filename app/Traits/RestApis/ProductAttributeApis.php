<?php

namespace App\Traits\RestApis;

use App\Http\Controllers\Admin\ProductAttribute;
use Illuminate\Http\Request;

trait ProductAttributeApis
{
    /**
     * @return ProductAttribute|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return ProductAttribute::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $items = $this->repository()->get();
        return json_success([
            'total' => $items->count(),
            'items' => $items
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
    public function store(Request $request, $id = 0)
    {
        $attribute = $request->input('attribute', []);
        $model = $this->repository()->findOrNew($id);
        $model->fill($attribute)->save();

        if (isset($attribute['options']) && is_array($attribute['options'])) {
            if ($id) {
                $model->options()->whereNotIn('id', collect($attribute['options'])->pluck('id'))->delete();
                foreach ($attribute['options'] as $option) {
                    $id = $option['id'] ?? 0;
                    if ($id > 0) {
                        $model->options()->whereKey($id)->update($option);
                    } else {
                        $model->options()->create($option);
                    }
                }
            } else {
                foreach ($attribute['options'] as $option) {
                    $model->options()->create($option);
                }
            }
        }

        return json_success($model);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $model = $this->repository()->findOrFail($id);
        $model->delete();

        return json_success();
    }

    public function batchDestroy(Request $request)
    {
        $this->repository()->whereKey($request->input('ids',[]))->get()->each->delete();

        return json_success();
    }
}