<?php

namespace App\Traits\RestApis;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait ShopApis
{
    /**
     * @return Shop|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Shop::withGlobalScope('avalaible', function (Builder $builder) {
            return $builder->where('status', Shop::STATUS_OPENING);
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository()->filter($request->all());

        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 20))->get()
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
        $shop = $this->repository()->findOrNew($id);
        $shop->fill($request->all());
        $shop->save();

        if ($request->has('shop.images')) {
            $images = collect($request->input('shop.images', []));
            $shop->images()->whereNotIn('id', $images->pluck('id'))->delete();

            foreach ($images as $k => $image) {
                $image['sort_num'] = $k;
                $shop->images()->updateOrCreate(['id' => $image['id'] ?? 0], $image);
            }
        }

        return json_success($shop);
    }

    public function update(Request $request, $id)
    {
        return $this->store($request, $id);
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