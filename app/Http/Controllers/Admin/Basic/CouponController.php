<?php

namespace App\Http\Controllers\Admin\Basic;

use App\Models\Coupon;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;

class CouponController extends BaseController
{
    /**
     * @return Coupon|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Coupon::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();
        return json_success([
            'total' => $query->count('id'),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 15))
                ->orderByDesc('id')->get()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id = null)
    {
        $coupon = $request->input('coupon', []);
        $model = $this->repository()->findOrNew($id);
        $model->fill($coupon);
        $model->save();

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchUpdate(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->update($request->input('data', []));
        return json_success();
    }
}
