<?php

namespace App\Http\Controllers\Admin\Basic;


use App\Models\Material;
use App\Traits\RestApis\MaterialApis;
use App\Http\Controllers\Admin\BaseController;

class MaterialController extends BaseController
{
    use MaterialApis;

    /**
     * @return Material|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Material::query();
    }
}
