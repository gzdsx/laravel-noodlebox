<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Models\UserPointTransaction;
use Illuminate\Http\Request;

class PointTransactionController extends BaseController
{
    protected function repository()
    {
        return UserPointTransaction::query();
    }

    public function index(Request $request)
    {
        $query = $this->repository();
        return json_success([
            'total' => $query->count(),
            'items' => $query->with(['user'])->offset($request->input('offset', 0))
                ->limit($request->input('limit', 15))
                ->orderByDesc('id')
                ->get()
        ]);
    }

    public function batchDestroy(Request $request)
    {
        $this->repository()->whereIn('id', $request->input('ids', []))->get()->each->delete();
        return json_success();
    }
}
