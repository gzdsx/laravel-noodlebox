<?php

namespace App\Http\Controllers\Admin\Basic;

use App\Models\Setting;
use App\Http\Controllers\Admin\BaseController;
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
     * @throws \Exception
     */
    public function update(Request $request)
    {
        foreach ($request->all() as $skey => $svalue) {
            Setting::updateOrCreate(['skey' => $skey], ['svalue' => $svalue]);
        }

        cache()->forget('settings');
        return json_success();
    }
}
