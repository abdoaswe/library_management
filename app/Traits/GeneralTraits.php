<?php


namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait GeneralTraits {

    public function responseSuccess($data = null, $message = 'Operation successful', $code = 200): JsonResponse {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);

    }


    public function responseError($message = 'Operation failed', $code = 400): JsonResponse {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    public function responseNotFound($message = 'Resource not found', $code = 404): JsonResponse {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    public function responseCreated($data = null, $message = 'Resource created successfully', $code = 201): JsonResponse {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
