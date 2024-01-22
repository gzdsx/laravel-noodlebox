<?php

namespace App\Traits\RestApis;

use App\Models\District;
use Illuminate\Http\Request;
use Overtrue\LaravelPinyin\Facades\Pinyin;

trait DistrictApis
{
    /**
     * @return District|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return District::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $query = $this->repository()->where('parent_id', $request->input('parent', 0));
        return json_success([
            'total' => $query->count(),
            'items' => $query->get(),
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
    public function store(Request $request, $id)
    {
        $newDistrict = $request->input('district', []);
        $model = $this->repository()->findOrNew($id);
        $model->fill($newDistrict);

        if (!$model->pinyin) {
            $model->pinyin = Pinyin::permalink($model->name, '');
        }

        if (!$model->letter) {
            $model->letter = substr(strtoupper($model->pinyin), 0, 1);
        }

        $model->save();

        return json_success($model);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDestroy(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->delete();
        return json_success();
    }
}