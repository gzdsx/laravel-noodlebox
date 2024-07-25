<?php

namespace App\Http\Controllers\Api\Lottery;

use App\Models\Cart;
use App\Models\LotteryPrize;
use App\Models\LotteryRecord;
use App\Models\LotterySetting;
use App\Models\UserPointTransaction;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
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
        $points = $settings['price'] ?? 0;
        if ($user->points < $points) {
            abort(422, $settings['insufficient_points'] ?? 'Insufficient points');
        }

        $prizes = LotteryPrize::where('stock', '>', 0)->where('status', 1)->get();
        $sort_keys = $prizes->pluck('probability', 'id')->toArray();
        $prizeId = $this->getPrizeId($sort_keys);
        $prize = LotteryPrize::find($prizeId);

        $user->points = bcsub($user->points, $points);
        $user->save();

        $transaction = new UserPointTransaction();
        $transaction->user()->associate($user);
        $transaction->points = $points;
        $transaction->type = 2;
        $transaction->detail = 'lottery cost points';
        $transaction->save();

        $record = new LotteryRecord();
        $record->name = $prize->name;
        $record->image = $prize->image;
        $record->points = $prize->points;
        $record->user()->associate($user);
        $record->save();

        if ($prize->type == 'product') {
            $meta_data = ['purchase_via' => 'lottery', 'prize_id' => $prize->id];
            $cart_hash = md5(json_encode([
                0,
                $meta_data,
                'lottery'
            ]));
            $cart = Cart::where(['cart_hash' => $cart_hash])->firstOrNew();
            if ($cart->id) {
                $cart->quantity += 1;
                $cart->save();
            } else {
                $cart->product_id = 0;
                $cart->title = $prize->name;
                $cart->image = $prize->image;
                $cart->quantity = 1;
                $cart->meta_data = $meta_data;
                $cart->purchase_via = 'lottery';
                $cart->user_id = $user->id;
                $cart->save();
            }
        } elseif ($prize->type == 'point') {
            $user->points = bcadd($user->points, $prize->points);
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
