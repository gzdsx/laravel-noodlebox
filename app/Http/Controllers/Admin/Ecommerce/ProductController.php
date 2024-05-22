<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Models\Product;
use App\Traits\RestApis\ProductApis;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    use ProductApis;

    protected function repository()
    {
        return Product::query();
    }

    public function batchAdjust(Request $request)
    {
        $ids = $request->input('ids', []);
        $action = $request->input('action', '');
        if ($action == 'listing') {
            $this->repository()->whereKey($ids)->get()->each->markAsOnSale();
        }

        if ($action == 'top') {
            $this->repository()->whereKey($ids)->update(['sticky' => 1]);
        }

        if ($action == 'untop') {
            $this->repository()->whereKey($ids)->update(['sticky' => 0]);
        }

        if ($action == 'delist') {
            $this->repository()->whereKey($ids)->get()->each->markAsDelisted();
        }

        if ($action == 'up') {
            $this->repository()->whereKey($ids)->get()->each->increment('sort_num', 1);
        }

        if ($action == 'down') {
            $this->repository()->where('sort_num', '>', 0)->whereKey($ids)->get()->each->decrement('sort_num', 1);
        }

        return json_success();
    }
}
