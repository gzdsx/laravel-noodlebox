<?php

namespace App\Http\Controllers\Admin\Locale;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class IndexController extends Controller
{
    public function messages($locale = null)
    {
        if (!$locale) {
            $locale = App::getLocale();
            //$locale = settings('language', 'zh_CN');
        }
        return json_success([
            'locale' => $locale,
            'messages' => trans('admin', [], $locale)
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function locale()
    {
        return json_success(App::getLocale());
    }
}
