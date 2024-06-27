<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Models\DeliveryerTransaction;
use Illuminate\Http\Request;

class DeliveryerTransactionController extends BaseController
{
    protected function repository()
    {
        return DeliveryerTransaction::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();
        $request->whenHas('deliveryer', function ($input) use ($query) {
            $query->where('deliveryer_id', $input);
        });

        return json_success([
            'total' => $query->count(),
            'items' => $query->with(['deliveryer'])
                ->offset($request->input('offset', 0))
                ->limit($request->input('limit', 10))
                ->orderByDesc('id')
                ->get()
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
     * @param $deliveryer_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $deliveryer_id, $id = null)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->all());
        $model->deliveryer_id = $deliveryer_id;
        $model->save();

        return json_success($model);
    }

    public function update($id, Request $request)
    {
        $model = $this->repository()->findOrFail($id);
        $model->fill($request->all());
        $model->save();

        return json_success($model);
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
            $this->repository()->find($id)->delete();
        }

        return json_success();
    }
}
