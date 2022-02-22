<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function apiSuccessResponse($data = null, $msg = 'success')
    {
        return response()->json([
            'status' => true,
            'message' => $msg,
            'data' => $data
        ], 200);
    }

    public function apiFailResponse($msg = 'fail')
    {
        return response()->json([
            'status' => false,
            'message' => $msg,
        ], 400);
    }
}
