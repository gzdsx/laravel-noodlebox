<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Models\PosMachine;
use Illuminate\Http\Request;

class PosMachineController extends BaseController
{
    protected function repository()
    {
        return PosMachine::query();
    }

    public function index(Request $request)
    {
        $query = $this->repository();
        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 10))
                ->orderBy('sort_num')->orderBy('id')->get()
        ]);
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|string',
            'base_amount' => 'required|numeric',
            'sort_num' => 'required|numeric'
        ]);

        $model = $this->repository()->findOrNew($id);
        $model->fill($request->all());
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
