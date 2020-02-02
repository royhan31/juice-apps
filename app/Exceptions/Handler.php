<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException as ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException as HttpExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Request;
use Response;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
      if ($exception instanceof ValidationException && $request->expectsJson()) {
        return response()->json([
          'message' => 'failed',
          'status' => false,
          'errors' => $exception->validator->getMessageBag()
        ], 422);
      }
      if ($exception instanceof HttpExceptionHandler) {
        return response()->json(['status' => false,'message' => 'not found'], 404);
      }
      if ($exception instanceof ModelNotFoundException) {
         return response()->json(['status' => false,'message' => "Not Found"], 404);
       }
      if ($exception instanceof NotFoundHttpException) {
         return response()->json(['status' => false,'message' => "Not Found"], 404);
       }
       // if ($exception instanceof AuthenticationException) {
       //   return response()->json(['status' => false,'message' => 'Unauthenticated',], 401);
       // }

       return parent::render($request, $exception);
    }
}
