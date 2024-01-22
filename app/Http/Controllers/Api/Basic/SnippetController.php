<?php

namespace App\Http\Controllers\Api\Basic;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Snippet;
use Illuminate\Http\Request;

class SnippetController extends BaseController
{
    /**
     * @return Snippet|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Snippet::query();
    }

    public function index(Request $request)
    {
        $query = $this->repository();

        return json_success([
            'total' => $query->count(),
            'items' => $query->get()
        ]);
    }

    public function show($id)
    {
        $model = $this->repository()->findOrNew($id);

        return json_success($model);
    }
}
