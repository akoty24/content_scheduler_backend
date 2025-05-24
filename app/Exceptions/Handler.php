<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class Handler extends ExceptionHandler
{
    // ...

    public function render($request, Throwable $exception)
    {
        // عند وجود خطأ تحقق (ValidationException) و الطلب يطلب JSON
        if ($exception instanceof ValidationException && $request->expectsJson()) {
            return response()->json([
                'message' => 'خطأ في التحقق من البيانات.',
                'errors' => $exception->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return parent::render($request, $exception);
    }
}
