<?php

namespace App\Http\Controllers\Api\Basic;

use App\Http\Controllers\Api\BaseController;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $title = $request->input('title');
        $message = $request->input('message');

        $model = new Feedback();
        $model->title = $title;
        $model->message = $message;
        $model->uid = Auth::id();
        $model->save();

        return json_success(['id' => $model->id]);
    }
}
