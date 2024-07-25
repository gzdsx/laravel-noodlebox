<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Models\Deliveryer;
use App\Models\DeliveryerTransaction;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
    public function index(Request $request, $deliveryer_id = 0)
    {
        $query = $this->repository();
        if ($deliveryer_id) {
            $query->where('deliveryer_id', $deliveryer_id);
        }

        return json_success([
            'total' => $query->count(),
            'items' => $query->with(['deliveryer', 'orders'])
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
    public function show($deliveryer_id, $id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $deliveryer_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $deliveryer_id)
    {
        $deliveryer = Deliveryer::findOrFail($deliveryer_id);
        $transaction = $deliveryer->generateTransaction();

        if ($request->filled('status')) {
            $transaction->status = $request->input('status');
        }
        if ($request->filled('notes')) {
            $transaction->notes = $request->input('notes');
        }
        $transaction->save();
        $transaction->orders()->sync($transaction->orders);

        $deliveryer->status = Deliveryer::STATUS_OFFLINE;
        $deliveryer->save();

        return json_success($transaction);
    }

    public function update(Request $request, $deliveryer_id, $id)
    {
        $transaction = $this->repository()->findOrFail($id);
        if ($request->filled('status')) {
            $transaction->status = $request->input('status');
        }

        if ($request->filled('notes')) {
            $transaction->notes = $request->input('notes');
        }

        $transaction->save();

        return json_success($transaction);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $deliveryer_id, $id)
    {
        if ($id == 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        } else {
            $this->repository()->find($id)->delete();
        }

        return json_success();
    }

    public function billing()
    {
        $deliveryers = \App\Models\Deliveryer::whereStatus(Deliveryer::STATUS_ONLINE)->get();
        $deliveryers->each(function ($deliveryer) {
            $deliveryer->billing = $deliveryer->generateTransaction();
        });

        return json_success($deliveryers);
    }
}
