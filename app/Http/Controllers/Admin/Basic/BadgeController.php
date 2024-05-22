<?php

namespace App\Http\Controllers\Admin\Basic;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeController extends BaseController
{
    protected function repository()
    {
        return Badge::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();
        $query->when($request->filled('type'), function ($query) use ($request) {
            return $query->where('type', $request->input('type'));
        });

        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 10))
                ->orderBy('sort_num', 'desc')
                ->get()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $id = null)
    {
        $this->validate($request, [
            'type' => 'required|string',
            'name' => 'required|string',
            'icon' => 'required|string',
        ]);

        $model = $this->repository()->findOrNew($id);
        $model->fill($request->all());
        $model->save();

        return json_success($model);
    }

    public function destroy($id)
    {
        $this->repository()->where('id', $id)->delete();
        return json_success();
    }

    public function show($id)
    {
        return json_success($this->repository()->find($id));
    }
}
