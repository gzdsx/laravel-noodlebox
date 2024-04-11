<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryerController extends BaseController
{
    protected function repository()
    {
        return \App\Models\Deliveryer::query();
    }

    public function index(Request $request)
    {
        $query = $this->repository();

        return json_success([
            'total' => $query->count(),
            'items' => $query->get()
        ]);
    }

    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
    }

    public function store(Request $request, $id = null)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->input('deliveryer', []));
        $model->save();

        return json_success($model);
    }

    public function destroy($id)
    {
        $this->repository()->find($id)->delete();
        return json_success();
    }

    public function batchDestroy(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        return json_success();
    }
}
