<?php

namespace App\Http\Controllers\Api\Basic;


use App\Traits\RestApis\DistrictApis;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

class DistrcitController extends BaseController
{
    use DistrictApis;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function query(Request $request)
    {
        $keyword = $request->input('keyword');
        $model = $this->repository()->where('name', 'like', "%$keyword%")->firstOrFail();
        return json_success($model);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCityList(Request $request)
    {
        $indexs = $this->repository()->where('level', 2)->whereNotNull('letter')->groupBy('letter')->get()->pluck('letter')->toArray();
        ksort($indexs);

        $cities = [];
        $this->repository()->with('parent')->where('level', 2)->whereNotNull('letter')->get()->map(function ($city) use (&$cities) {
            $cities[$city->letter][] = $city;
        });
        ksort($cities);

        return json_success(compact('indexs', 'cities'));
    }
}
