<?php

namespace App\Http\Controllers\Api\User;


use App\Models\UserTransaction;
use App\Traits\RestApis\UserTransactionApis;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;

class BillController extends BaseController
{
    use UserTransactionApis;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|UserTransaction
     */
    protected function repository()
    {
        return Auth::user()->transactions();
    }
}
