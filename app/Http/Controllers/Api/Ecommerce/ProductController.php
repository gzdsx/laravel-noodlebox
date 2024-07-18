<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Traits\RestApis\ProductApis;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

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
