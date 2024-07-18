<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class PointController extends BaseController
{
    public function index()
    {
        return json_success([
            'points' => Auth::user()->points,
            'exchange_rate' => settings('points_exchange_rate', 1),
            'tips' => 'Your points balance is ' . Auth::user()->points . ', 1 point = ' . settings('points_exchange_rate', 1) . '€',
            'referralLink' => url('/?u=' . Hashids::encodeHex(Auth::id())),
            'referral_points' => settings('referral_points'),
            'referral_link_description' => settings('referral_link_description')
        ]);
    }
}
