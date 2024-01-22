<?php

namespace App\Http\Controllers\Admin\Basic;


use App\Http\Controllers\Admin\BaseController;
use App\Traits\RestApis\DistrictApis;

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
