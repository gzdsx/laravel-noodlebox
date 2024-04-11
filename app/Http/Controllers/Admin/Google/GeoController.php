<?php

namespace App\Http\Controllers\Admin\Google;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeoController extends BaseController
{
    public function code(Request $request)
    {

    }

    public function recode(Request $request)
    {
        $query = http_build_query([
            'language' => 'en',
            'key' => settings('google_apikey'),
            'latlng' => $request->input('latlng')
        ]);
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key='.settings('');
    }
}
