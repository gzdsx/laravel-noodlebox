<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request)
    {

    }

    /**
     * @param $data
     * @param $options
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = [], $options = JSON_UNESCAPED_UNICODE)
    {
        return json_success($data, $options);
    }

    /**
     * @param $message
     * @param $code
     * @param $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message, $code = 422, $errors = null)
    {
        return json_error($message, $code, $errors);
    }
}
