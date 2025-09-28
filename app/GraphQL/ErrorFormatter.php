<?php

namespace App\GraphQL;

use GraphQL\Error\Error;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Throwable;

class ErrorFormatter
{
    public static function formatError(Error $e): array
    {
        $previous = $e->getPrevious();

        // ✅ Validation errors
        if ($previous instanceof ValidationException) {
            return [
                'message' => 'Validation failed',
                'locations' => $e->getLocations(),
                'path' => $e->getPath(),
                'extensions' => [
                    'code' => 422,
                    'validation' => $previous->errors(),
                ],
            ];
        }

        // ✅ Model not found
        if ($previous instanceof ModelNotFoundException) {
            return [
                'message' => 'Resource not found',
                'locations' => $e->getLocations(),
                'path' => $e->getPath(),
                'extensions' => [
                    'code' => 404,
                    'exception' => 'ModelNotFoundException',
                ],
            ];
        }

        // ✅ Authentication (unauthenticated user)
        if ($previous instanceof AuthenticationException) {
            return [
                'message' => 'Unauthenticated',
                'locations' => $e->getLocations(),
                'path' => $e->getPath(),
                'extensions' => [
                    'code' => 401,
                    'exception' => 'AuthenticationException',
                ],
            ];
        }

        // ✅ Authorization (forbidden action)
        if ($previous instanceof AuthorizationException) {
            return [
                'message' => 'Unauthorized',
                'locations' => $e->getLocations(),
                'path' => $e->getPath(),
                'extensions' => [
                    'code' => 403,
                    'exception' => 'AuthorizationException',
                ],
            ];
        }

        // ✅ Generic error (default to 500)
        return [
            'message' => $e->getMessage(),
            'locations' => $e->getLocations(),
            'path' => $e->getPath(),
            'extensions' => [
                'code' => $previous?->getCode() ?: 500,
                'exception' => $previous instanceof Throwable
                    ? class_basename($previous)
                    : class_basename($e),
            ],
        ];
    }
}
