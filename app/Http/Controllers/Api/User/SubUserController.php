<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubUserController extends BaseController
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|User
     */
    protected function repository()
    {
        return Auth::user()->subUsers();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request)
    {
        $query = $this->repository();
        return json_success([
            'total' => $query->count(),
            'items' => $query->with(['member'])
                ->offset($request->input('offset', 0))
                ->take($request->input('count', 10))
                ->orderByDesc('id')->get()
        ]);
    }
}
