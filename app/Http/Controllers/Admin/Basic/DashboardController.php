<?php

namespace App\Http\Controllers\Admin\Basic;

use App\Models\Material;
use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function posts(Request $request)
    {
        return json_success(['items' => Post::limit(5)->orderByDesc('id')->get()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats(Request $request)
    {
        return json_success([
            'users' => User::count(),
            'posts' => Post::count(),
            'materials' => Material::count()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function users(Request $request)
    {
        return json_success(['items' => User::orderByDesc('uid')->limit(10)->get()]);
    }
}
