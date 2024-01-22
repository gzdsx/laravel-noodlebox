<?php

namespace App\Traits\RestApis;

use App\Models\Category;
use Illuminate\Http\Request;
use Overtrue\LaravelPinyin\Facades\Pinyin;

trait CategoryApis
{
    /**
     * @return Category|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Category::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository()
            ->where('taxonomy', $request->input('taxonomy', 'post'))
            ->where('parent_id', $request->input('parent_id', 0));
        return json_success([
            'total' => $query->count(),
            'items' => $query->with('children')->get()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $parent_id = $request->input('parent_id', 0);
        return json_success(['items' => $this->repository()->where('parent_id', $parent_id)->get()]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id = null)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->input('category', []));
        $model->save();

        return json_success($model);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function increase($id)
    {
        $model = $this->repository()->find($id);
        $prev = $model->siblings()->where('sort_num', '<', $model->sort_num)->max('sort_num');
        $model->sort_num = $prev > 0 ? $prev - 1 : 0;
        $model->save();

        return json_success();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function decrease($id)
    {
        $model = $this->repository()->find($id);
        $next = $model->siblings()->where('sort_num', '>', $model->sort_num)->min('sort_num');
        $model->sort_num = $next + 1;
        $model->save();

        return json_success();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->deleteAll($id);
        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function batchDestroy(Request $request)
    {
        foreach ($request->input('ids', []) as $cate_id) {
            $this->deleteAll($cate_id);
        }
        return json_success();
    }

    /**
     * @param $catid
     * @throws \Exception
     */
    private function deleteAll($cate_id)
    {
        $category = $this->repository()->find($cate_id);
        if ($category) {
            if ($category->children) {
                foreach ($category->children as $child) {
                    $this->deleteAll($child->cate_id);
                }
            }
            $category->delete();
        }
    }
}