<?php


namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    public function report(Throwable $exception)
    {
        if (!($exception instanceof ValidationException) && !($exception instanceof NotFoundHttpException)) {
            Log::error("File: ".$exception->getFile()." Line: ".$exception->getLine()." Error: ".$exception->getMessage() );
        }

        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        $expectedExceptions = [
            NotFoundHttpException::class,
            ValidationException::class,
            ThrottleRequestsException::class,
        ];

        if (!in_array(get_class($exception), $expectedExceptions)) {
            return response()->json(["status" => false, "errors" => "Unexpected error"], 500);
        }

        return parent::render($request, $exception);
    }


}
