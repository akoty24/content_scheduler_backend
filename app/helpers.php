<?php
use Illuminate\Http\JsonResponse;

if (!function_exists('success')) {
    function success($data = null, $message = null): JsonResponse
    {
        if ($data ) return response()->json(['data' => $data  , 'message' => $message, 'status' => 'success']);
        $response = [
            'message' => $message,
            'status' => 'success',
            'data' => $data,
        ];
        return response()->json($response);
    }
}
if (!function_exists('error')) {
    function error($message = null, $code = 400): JsonResponse
    {
        $response = [
            'message' => $message,
            'status' => 'error',
           
        ];
        return response()->json($response, $code);
    }
}