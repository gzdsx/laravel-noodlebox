<?php

namespace App\Http\Controllers\Api\Lottery;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\LotteryPrize;
use App\Models\LotteryRecord;
use App\Models\LotterySetting;
use App\Models\UserPointTransaction;
use Illuminate\Http\Request;

class LotteryController extends BaseController
{
    public function settings()
    {
        $settings = LotterySetting::get()->pluck('svalue', 'skey');
        return json_success($settings);
    }

    public function draw(Request $request)
    {
        $user = auth()->user();
        $settings = LotterySetting::get()->pluck('svalue', 'skey');
        if ($user->points < $settings['price']) {
            abort(422, $settings['insufficient_points'] ?? 'Insufficient points');
        }

        $prizes = LotteryPrize::where('stock', '>', 0)->where('status', 1)->get();
        $sort_keys = $prizes->pluck('probability', 'id')->toArray();
        $prizeId = $this->getPrizeId($sort_keys);
        $prize = LotteryPrize::find($prizeId);

        $record = new LotteryRecord();
        $record->name = $prize->name;
        $record->image = $prize->image;
        $record->points = $prize->points;
        $record->user()->associate($user);
        $record->save();

        if ($prize->type == 'product') {
            $cart = Cart::firstOrNew(['user_id' => $user->id, 'product_id' => $prize->id, 'purchase_via' => 'lottery']);
            $cart->title = $prize->name;
            $cart->image = $prize->image;
            $cart->quantity += 1;
            $cart->meta_data = [
                'is_gift' => 'yes'
            ];
            $cart->save();
        } elseif ($prize->type == 'point') {
            $user->points += $prize->points;
            $user->save();

            $transaction = new UserPointTransaction();
            $transaction->user()->associate($user);
            $transaction->points = $prize->points;
            $transaction->type = 1;
            $transaction->detail = 'lottery';
            $transaction->save();
        }

        return json_success($prize);
    }

    function getPrizeId($proArr)
    {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
    }
}
