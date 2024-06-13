<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Models\DeliveryerTransaction;
use Illuminate\Http\Request;

class DeliveryerTransactonController extends BaseController
{
    protected function repository()
    {
        return DeliveryerTransaction::query();
    }

    public function index(Request $request, $id = 0)
    {
        $query = $this->repository();
        if ($id) $query->where('deliveryer_id', $id);

        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 10))
                ->orderBy('id', 'desc')
                ->get()
        ]);
    }

    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
    }

    public function store(Request $request, $deliveryer_id, $id = null)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->all());
        $model->deliveryer_id = $deliveryer_id;
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
