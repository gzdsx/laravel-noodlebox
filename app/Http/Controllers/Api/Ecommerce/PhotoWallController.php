<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Models\PhotoWall;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhotoWallController extends BaseController
{
    protected function repository()
    {
        return PhotoWall::query();
    }

    public function index(Request $request)
    {
        $query = $this->repository();
        $total = $query->count();
        $items = $query->offset($request->input('offset', 0))
            ->limit($request->input('limit', 128))->orderByDesc('sort_num')->get();

        return json_success([
            'total' => $total,
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
    }

    public function store(Request $request, $id)
    {
        $model = $this->repository()->create($request->all());
        return json_success($model);
    }

    public function batchStore(Request $request)
    {
        if ($files = $request->input('photos', [])) {
            foreach (array_values($files) as $k => $file) {
                $this->repository()->create([
                    'title' => $file['title'],
                    'description' => $file['description'],
                    'image' => $file['image'],
                    'thumb' => $file['thumb'],
                    'sort_num' => $k
                ]);
            }
        }

        return json_success();
    }

    public function update(Request $request, $id)
    {
        $model = $this->repository()->findOrFail($id);
        $model->fill($request->all())->save();
        return json_success($model);
    }

    public function destroy($id)
    {
        $model = $this->repository()->findOrFail($id);
        $model->delete();
        return json_success();
    }
}
