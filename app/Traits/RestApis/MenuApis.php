<?php

namespace App\Traits\RestApis;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

trait MenuApis
{
    /**
     * @return Menu|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Menu::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return json_success(['items' => $this->repository()->get()]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $menu = $this->repository()->findOrFail($id);
        $items = $menu->visibleItems()->with(['children' => function (HasMany $hasMany) {
            return $hasMany->where('hide', 0);
        }])->where('parent_id', 0)->get();

        return json_success(['menu' => $menu, 'items' => $items]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id = 0)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->input('menu', []))->save();
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
}