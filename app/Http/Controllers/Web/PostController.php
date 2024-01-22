<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    protected $navName = 'post';

    /**
     * @return Post|Builder
     */
    protected function repository()
    {
        return Post::withGlobalScope('avalaible', function (Builder $builder) {
            return $builder->where('status', Post::STATUS_PUBLISH);
        });
    }

    public function index(Request $request, $cate = 0)
    {

        $category = Category::findOrNew($cate);
        $items = $this->repository()->filter(['cate' => $cate, 'sort' => 'time-desc'])->paginate();

        return view('web.post-home', compact('items', 'category'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        if (preg_match('/^[0-9]+$/', $id)) {
            $post = $this->repository()->withoutGlobalScopes()->find($id);
        } else {
            $post = $this->repository()->withoutGlobalScopes()->where('name', 'like', "%$id%")->first();
        }

        if (!$post) {
            abort(404, trans('post.the post has been deleted'));
        }

        $post->incrementViews();
        $tags = preg_split('/\s/', $post->tags);

        $view = 'web.single-' . $post->type;
        if (!view()->exists($view)) {
            $view = 'web.single';
        }

        return view($view, compact('post', 'tags'));
    }
}
