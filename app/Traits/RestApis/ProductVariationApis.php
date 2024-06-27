<?php

namespace App\Traits\RestApis;


use App\Models\ProductVariation;
use Illuminate\Http\Request;

trait ProductVariationApis
{
    /**
     * @return ProductVariation|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return ProductVariation::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();
        return json_success([
            'total' => $query->count(),
            'items' => $this->repository()->offset($request->input('offset', 0))
                ->limit($request->input('limit', 15))->get()
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
        $variation = $request->input('variation', []);
        $model = $this->repository()->findOrNew($id);
        $model->fill($variation)->save();

        if (isset($variation['options']) && is_array($variation['options'])) {
            if ($id) {
                $model->options()->whereNotIn('id', collect($variation['options'])->pluck('id'))->delete();
                foreach ($variation['options'] as $option) {
                    $id = $option['id'] ?? 0;
                    if ($id > 0) {
                        $model->options()->whereKey($id)->update($option);
                    } else {
                        $model->options()->create($option);
                    }
                }
            } else {
                foreach ($variation['options'] as $option) {
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
        $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();

        return json_success();
    }
}