<?php

namespace App\Traits\RestApis;

use App\Models\ShippingZone;
use Illuminate\Http\Request;

trait ShippingZoneApis
{
    /**
     * @return ShippingZone|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return ShippingZone::query();
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
        $model->fill($request->all())->save();
        return json_success($model);
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
            $this->repository()->whereKey($request->input('ids', []))->delete();
        } else {
            $this->repository()->findOrFail($id)->delete();
        }

        return json_success();
    }
}