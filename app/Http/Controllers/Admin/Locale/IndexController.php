<?php

namespace App\Http\Controllers\Admin\Locale;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class IndexController extends Controller
{
    public function messages()
    {
        $locale = App::getLocale();
        return json_success([
            'locale' => $locale,
            'messages' => [
                'en' => trans('admin', [], 'en'),
                'zh-CN' => trans('admin', [], 'zh-CN')
            ]
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
