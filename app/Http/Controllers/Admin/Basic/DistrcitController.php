<?php

namespace App\Http\Controllers\Admin\Basic;


use App\Traits\RestApis\DistrictApis;
use App\Http\Controllers\Admin\BaseController;

class DistrcitController extends BaseController
{
    use DistrictApis;

    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        $model->load(['ancestor']);
        return json_success($model);
    }
}
