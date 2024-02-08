<?php

namespace App\Http\Controllers\Api\Lang;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LangController extends BaseController
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
