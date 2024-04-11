<?php

namespace App\Http\Controllers\Api\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Traits\RestApis\ProductApis;

class ProductController extends BaseController
{
    use ProductApis;

    public function updateColor(Request $request, $id)
    {
        $product = $this->repository()->find($id);
        $product->updateMeta('_pos_color', $request->input('color'));

        return json_success();
    }
}
