<?php

namespace App\Traits\RestApis;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait ProductApis
{
    /**
     * @return Builder|Product
     */
    protected function repository()
    {
        return Product::withGlobalScope('available', function (Builder $builder) {
            return $builder->where('status', Product::STAUTS_ONSALE);
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $query = $this->repository()->filter($request->all());

        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($offset)->take($limit)->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        $model->incrementViews();
        $model->load(['skus', 'content']);
        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request, $id = null)
    {
        $product = DB::transaction(function () use ($request, $id) {
            $newProduct = collect($request->input('product', []));
            $model = $this->repository()->findOrNew($id);
            $model->fill($newProduct->toArray());
            $model->save();

            if ($newProduct->has('content')) {
                $content = $model->content()->firstOrNew();
                $content->fill($newProduct->get('content', []));
                $content->save();
            }

            if ($newProduct->has('categories')) {
                $model->categories()->sync($newProduct->get('categories', []));
            }

            if ($newProduct->has('images')) {
                $images = collect($newProduct->get('images', []));
                $model->images()->whereNotIn('id', $images->pluck('id'))->delete();

                foreach ($images as $k => $v) {
                    $v['sort_num'] = $k;
                    $model->images()->updateOrCreate(['id' => $v['id'] ?? 0], $v);
                }

                if (!$model->image){
                    if ($first = $images->first()) {
                        $model->image = $first['image'] ?? null;
                        $model->save();
                    }
                }
            }

            if ($model->has_sku_attr) {
                if ($newProduct->has('skus')) {
                    $skus = $newProduct->get('skus', []);
                    $model->skus()->whereNotIn('id', collect($skus)->pluck('id'))->delete();
                    foreach ($skus as $sku) {
                        $model->skus()->updateOrCreate(['id' => $sku['id'] ?? 0], $sku);
                    }
                }
            } else {
                $model->skus()->delete();
            }

            if ($newProduct->has('meta_data')) {
                foreach ($newProduct->get('meta_data', []) as $meta_key => $meta_value) {
                    $model->updateMeta($meta_key, $meta_value);
                }
            }

            $model->refresh();
            return $model;
        });

        return json_success($product);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function batchDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (is_array($ids)) {
            $this->repository()->whereKey($ids)->get()->each->delete();
        } else {
            if ($model = $this->repository()->find($request->input('ids'))) {
                $model->delete();
            }
        }
        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchUpdate(Request $request)
    {
        $ids = $request->input('ids', []);
        $data = $request->input('data', []);
        foreach ($this->repository()->whereKey($ids)->get() as $product) {
            $product->fill($data)->save();
        }

        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Request $request)
    {
        $product = $this->repository()->find($request->input('id'));
        $product->isForSale() ? $product->markAsOffSale() : $product->markAsForSale();

        return json_success();
    }
}