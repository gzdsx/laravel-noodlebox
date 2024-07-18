<?php

namespace App\Http\Controllers\Api\Basic;


use App\Models\Feedback;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends BaseController
{
    /**
     * @return Feedback|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Feedback::query();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->success();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $feedback = Feedback::create($request->only(['title', 'message']));

        return $this->success($feedback);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        return $this->success();
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
        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        if ($id == 'batch') {
            $this->repository()->whereKey($request->input('ids'))->delete();
        } else {
            $this->repository()->findOrFail($id)->delete();
        }

        return $this->success();
    }
}
