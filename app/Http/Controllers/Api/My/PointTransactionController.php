<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PointTransactionController extends BaseController
{
    /**
     * @return \App\Models\UserPointTransaction|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return \App\Models\UserPointTransaction::withGlobalScope('owner', function ($builder) {
            $builder->where('user_id', auth()->id());
        });
    }

    public function index(Request $request)
    {
        $query = $this->repository();
        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 15))
                ->orderByDesc('id')
                ->get()
        ]);
    }
}
