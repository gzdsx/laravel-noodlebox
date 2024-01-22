<?php

namespace App\Traits\RestApis;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

trait MenuItemApis
{
    protected function repository()
    {
        return MenuItem::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $menu = Menu::findOrFail($request->input('menu_id'));
        $items = $menu->items()->with(['children'])->where('parent_id', 0)->get();

        return json_success(['items' => $items, 'menu' => $menu]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->find($id);
        return json_success($model);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id = null)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->input('item', []))->save();
        if (!$model->sort_num) {
            $model->sort_num = $model->id;
            $model->save();
        }
        return json_success($model);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDestroy(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Request $request)
    {
        $model = $this->repository()->find($request->input('id'));
        $model->hide = $model->hide === 0 ? 1 : 0;
        $model->save();

        return json_success();
    }
}