<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * @return \App\Models\Role|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return \App\Models\Role::query();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $qeury = $this->repository();

        return json_success([
            'items' => $qeury->get(),
            'total' => $qeury->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $role = $this->repository()->create($request->all());

        return json_success($role);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $role = $this->repository()->findOrFail($id);

        return json_success($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $role = $this->repository()->findOrFail($id);
        $role->update($request->all());

        return json_success($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        if ($id == 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        } else {
            $this->repository()->findOrFail($id)->delete();
        }

        return json_success();
    }
}
