<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        //
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Force JSON for API & GraphQL requests
        if ($request->expectsJson() || $request->is('graphql')) {
            $status = $this->getStatusCode($exception);

            $errorMessage = $exception->getMessage() ?: $this->getDefaultMessage($status);

            return response()->json([
                'errors' => [
                    [
                        'message' => $errorMessage,
                        'code' => $status,
                        'exception' => class_basename($exception),
                    ]
                ]
            ], 200); // GraphQL convention: always 200
        }

        return parent::render($request, $exception);
    }

    /**
     * Map exception to status code.
     */
    protected function getStatusCode(Throwable $exception): int
    {
        if ($exception instanceof NotFoundHttpException) {
            return 404;
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return 405;
        }

        if ($exception instanceof AuthorizationException) {
            return 403;
        }

        if ($exception instanceof AuthenticationException) {
            return 401;
        }

        if ($exception instanceof ModelNotFoundException) {
            return 404;
        }

        if ($exception instanceof HttpException) {
            return $exception->getStatusCode();
        }

        return 500;
    }

    /**
     * Default messages when exception has no message.
     */
    protected function getDefaultMessage(int $status): string
    {
        return match ($status) {
            401 => 'Unauthenticated',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            default => 'Server Error',
        };
    }
}
