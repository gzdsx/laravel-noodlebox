<?php

namespace App\Traits\RestApis;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait PostApis
{
    protected $with = ['user', 'categories'];

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
            'items' => $query->with($this->with)->offset($offset)->limit($limit)->get()
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
        $model->load(['content', 'user', 'images', 'categories', 'metas']);

        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id = null)
    {
        $newPost = collect($request->input('post', []));
        $model = $this->repository()->findOrNew($id);
        $model->fill($newPost->toArray())->save();
        $model->save();

        if ($newPost->has('categories')) {
            $model->categories()->sync($newPost->get('categories', []));
        }

        if ($newPost->has('content')) {
            $newContent = $newPost->get('content', []);
            $content = $model->content()->firstOrNew();
            $content->fill($newContent)->save();

            if (!$model->excerpt) {
                $model->excerpt = mbsubstr(strip_html($content->content), 200);
                $model->save();
            }
        }

        if ($newPost->has('media')) {
            $media = $model->media()->firstOrNew();
            $media->fill($newPost->get('media', []))->save();
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

        return json_success(['id' => $model->id]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->repository()->whereKey($id)->get()->each->delete();
        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDelete(Request $request)
    {
        $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchUpdate(Request $request)
    {
        $data = $request->input('data', []);
        $this->repository()->whereKey($request->input('ids', []))->update($data);

        return json_success();
    }
}