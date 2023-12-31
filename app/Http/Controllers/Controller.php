<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Handle Api response error
     *
     * @param string $message
     * @param int $code
     * @param int $httpStatus
     * @return JsonResponse
     */
    final protected function responseJsonError(
        string $message,
        int $code = COMMON_ERROR,
        int $httpStatus = Response::HTTP_UNPROCESSABLE_ENTITY
    ) {
        return response()->json(
            [
                'code' => $code,
                'message' => $message,
            ],
            $httpStatus
        );
    }
}
