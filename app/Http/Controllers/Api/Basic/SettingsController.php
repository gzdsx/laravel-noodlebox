<?php

namespace App\Http\Controllers\Api\Basic;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function settings(Request $request)
    {
        $settings = [];
        foreach (Setting::all() as $setting) {
            $svalue = json_decode($setting->svalue, true);
            $settings[$setting->skey] = is_array($svalue) ? $svalue : $setting->svalue;
        }
        return json_success($settings);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request)
    {
        foreach ($request->input('settings', []) as $skey => $svalue) {
            if (is_array($svalue)) $svalue = json_encode($svalue);
            Setting::updateOrInsert(['skey'=>$skey], ['svalue' => $svalue]);
        }

        $this->updateCache();
        return json_success();
    }

    /**
     * @throws \Exception
     */
    protected function updateCache()
    {
        // TODO: Implement updateCache() method.
        $settings = [];
        foreach (Setting::all() as $setting) {
            $svalue = json_decode($setting->svalue, true);
            $settings[$setting->skey] = is_array($svalue) ? $svalue : $setting->svalue;
        }
        cache()->forever('settings', $settings);
    }
}
