<?php

namespace App\Http\Controllers\Admin\Lottery;

use App\Models\LotterySetting;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends BaseController
{
    protected function repository()
    {
        return LotterySetting::query();
    }

    public function index()
    {
        $settings = $this->repository()->get()->pluck('svalue', 'skey');
        return json_success($settings);
    }

    public function update(Request $request)
    {
        foreach ($request->input('settings', []) as $skey => $svalue) {
            $this->repository()->updateOrCreate(['skey' => $skey], ['svalue' => $svalue]);
        }

        return json_success();
    }
}
