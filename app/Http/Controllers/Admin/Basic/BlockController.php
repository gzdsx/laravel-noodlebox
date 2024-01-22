<?php

namespace App\Http\Controllers\Admin\Basic;


use App\Http\Controllers\Admin\BaseController;
use App\Models\BlockItem;
use App\Traits\RestApis\BlockApis;
use Illuminate\Http\Request;

class BlockController extends BaseController
{
    use BlockApis;

    public function storeItems(Request $request, $id = null)
    {
        $model = BlockItem::query()->findOrNew($id);
        $model->fill($request->input('item', []));
        $model->save();
        return json_success($model);
    }

    public function destroyItems(Request $request)
    {
        BlockItem::whereKey($request->input('ids', []))->delete();

        return json_success();
    }
}
