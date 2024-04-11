<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Traits\RestApis\PostApis;

class PostController extends Controller
{
    use PostApis;

    /**
     * @return Post|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Post::query();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->findOrNew($id);
        $model->incrementViews();
        $model->load(['content', 'images', 'categories', 'metas']);

        return json_success($model);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function formats()
    {
        return json_success(trans('post.formats'));
    }
}
