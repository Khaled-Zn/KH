<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

   public function render($request, Throwable $e) {
       if ($request->wantsJson()) {
           return $this->handleApiException($request, $e);
       } else {
           $retval = parent::render($request, $e);
       }

       return $retval;
   }
    private function handleApiException($request, Throwable $exception) {

        if($exception instanceof  \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
                'errorMessage' => 'Resourse not found'], 404);
        }
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json(['errorMessage' => $exception->getMessage()], 401);
        }
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'error' => $exception->errors(),
            ], $exception->status);
        }
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'errorMessage' => 'There is no ' . $exception->getModel() . 'with id ' . $exception->getIds()[0]], 404);
        }
        if($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return response()->json([
                'errorMessage' => 'You do not have the required authorization.',
            ],403);
        }
        if($exception instanceof \Spatie\Permission\Exceptions\RoleDoesNotExist) {
            return response()->json([
                'errorMessage' => $exception->getMessage(),
            ],404);
        }
        return $this->customApiResponse($exception);
    }
    private function customApiResponse($exception) {

        if ($exception->getCode()) {
            $statusCode = $exception->getCode();
        } else {
            $statusCode = 500;
        }

        $response = [];

        switch ($statusCode) {
            case 401:
            case 404:
            case 409:
                $response['errorMessage'] = $exception->getMessage();
                break;
            case 403:
                $response['errorMessage'] = 'Forbidden';
                break;
            case 405:
                $response['errorMessage'] = 'Method Not Allowed';
                break;
            default:
                $response['errorMessage'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
                break;
        }
        return response()->json($response, $statusCode);
    }
}
