<?php

namespace App\Http\Controllers\Api\My;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends BaseController
{
    public function index()
    {
        return json_success([
            'points' => Auth::user()->points,
            'exchange_rate' => settings('points_exchange_rate', 1),
            'tips' => 'Your points balance is ' . Auth::user()->points . ', 1 point = ' . settings('points_exchange_rate', 1) . '€'
        ]);
    }
}
