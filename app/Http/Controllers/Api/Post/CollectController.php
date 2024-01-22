<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectController extends BaseController
{
    /**
     * @return \App\Models\Post|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected function repository()
    {
        return Auth::user()->collectedPosts();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();

        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 10))->get()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function query(Request $request)
    {
        $post_id = $request->input('post_id');
        $exists = $this->repository()->whereKey($post_id)->exists();

        return json_success($exists);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Request $request)
    {
        $post_id = $request->input('post_id');
        $res = $this->repository()->toggle([$post_id]);

        return json_success($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Request $request)
    {
        $post_id = $request->input('post_id');
        $res = $this->repository()->detach([$post_id]);

        return json_success($res);
    }
}
