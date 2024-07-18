<?php

namespace App\Traits\RestApis;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait PostApis
{

    /**
     * @return Post|Builder
     */
    protected function repository()
    {
        return Post::withGlobalScope('avalaible', function (Builder $builder) {
            return $builder->where('status', Post::STATUS_PUBLISH);
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 15);
        $query = $this->repository()->filter($request->all());
        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($offset)->limit($limit)->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        $model->incrementViews();
        $model->load(['content']);

        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id = null)
    {
        $newPost = collect($request->all());
        $model = $this->repository()->findOrNew($id);
        $model->fill($newPost->only($model->getFillable())->toArray())->save();
        $model->save();

        if ($newPost->has('categories')) {
            $model->categories()->sync($newPost->get('categories', []));
        }

        if ($newPost->has('content')) {
            $newContent = $newPost->get('content', []);
            $content = $model->content()->firstOrNew();
            $content->fill($newContent)->save();

            if (!$model->description) {
                $model->description = mbsubstr(strip_html($content->content), 300, '...');
                $model->save();
            }
        }

        if ($newPost->has('images')) {
            $images = $newPost->get('images', []);
            $model->images()->whereNotIn('id', collect($images)->pluck('id'))->delete();

            foreach ($images as $k => $v) {
                $v['sort_num'] = $k;
                $model->images()->updateOrCreate(['id' => $v['id'] ?? 0], $v);

                if (!$model->image) {
                    $model->image = $v['image'] ?? null;
                    $model->save();
                }
            }
        }

        if ($newPost->has('metas')) {
            foreach ($newPost->get('metas', []) as $meta_key => $meta_value) {
                $model->updateMeta($meta_key, $meta_value);
            }
        }

        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($id == 'batch') {
            $data = $request->input('data', []);
            $this->repository()->whereKey($request->input('ids', []))->update($data);
            return json_success();
        }

        return $this->store($request, $id);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        } else {
            $this->repository()->whereKey($id)->get()->each->delete();
        }
        return json_success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function options()
    {
        return json_success([
            'formats' => trans('post.formats'),
            'statuses' => trans('post.statuses'),
        ]);
    }
}