<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\UserPointTransaction;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->has('u')) {
            $user_id = Hashids::decodeHex($request->input('u'));
            if ($user_id) {
                $transaction = new UserPointTransaction();
                $transaction->user_id = $user_id;
                $transaction->points = settings('referral_points', 10);
                $transaction->detail = 'Referral Link';
                $transaction->type = 1;
                $transaction->save();

                $user = User::find($user_id);
                $user->points += settings('referral_points', 10);
                $user->save();
            }
        }
        return view('web.index');
    }

    public function message()
    {

    }
}
