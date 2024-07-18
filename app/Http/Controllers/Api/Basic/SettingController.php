<?php

namespace App\Http\Controllers\Api\Basic;

use App\Models\Setting;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

class SettingController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $settings = Setting::get()->pluck('svalue', 'skey');
        return json_success($settings);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        foreach ($request->input('settings', []) as $skey => $svalue) {
            Setting::updateOrCreate(['skey' => $skey], ['svalue' => $svalue]);
        }

        return json_success(settings());
    }
}
