<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Models\PosMachine;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PosMachineController extends BaseController
{
    protected function repository()
    {
        return PosMachine::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();
        if ($status = $request->input('status')) {
            if ($status === 'online') {
                $query->whereHas('deliveryer');
            } else {
                $query->whereDoesntHave('deliveryer');
            }

        }

        $request->whenFilled('is_cashier', function ($input) use ($query) {
            $query->where('is_cashier', $input);
        });
        return json_success([
            'total' => $query->count(),
            'items' => $query->with(['deliveryer'])
                ->offset($request->input('offset', 0))
                ->limit($request->input('limit', 10))
                ->orderBy('sort_num')->orderBy('id')->get()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        return $this->store($request, $id);
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
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->delete();
        } else {
            $this->repository()->whereKey($id)->delete();
        }
        return json_success();
    }
}
