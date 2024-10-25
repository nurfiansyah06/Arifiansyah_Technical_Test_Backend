<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class Helpers 
{
    public static function success($data = null, $message = 'Success', $statusCode): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public static function failed($data = null, $message = 'Failed', $statusCode): JsonResponse
    {
        return response()->json([
            'status' => 'failed',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}