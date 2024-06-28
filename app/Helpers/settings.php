<?php

use App\Models\Setting;

/**
 * @param $name
 * @param $default
 * @return \Illuminate\Support\Collection|mixed
 * @throws Exception
 */
function settings($name = null, $default = null)
{
    static $_settings;
    if (empty($_settings)) {
        $_settings = collect(Setting::settingsFromCache());
    }

    if (is_null($name)) {
        return $_settings;
    } else {
        return $_settings->get($name, $default);
    }
}

function update_setting($skey, $svalue)
{
    return Setting::updateOrCreate(['skey' => $skey], ['svalue' => $svalue]);
}

function remove_setting($skey)
{
    Setting::whereSkey($skey)->delete();
}