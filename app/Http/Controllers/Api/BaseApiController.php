<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class BaseApiController extends Controller
{
    /**
     * Build a successful JSON response.
     */
    protected function success($data = null, string $message = 'OK', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * 201 Created response
     */
    protected function created($data = null, string $message = 'Created'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    /**
     * Build an error JSON response.
     */
    protected function error(string $message = 'Server Error', int $status = 500, $errors = null): JsonResponse
    {
        $payload = [
            'success' => false,
            'message' => $message,
        ];
        if (! is_null($errors)) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }

    /**
     * Map known exceptions to proper API responses.
     */
    protected function fromException(Throwable $e): JsonResponse
    {
        if ($e instanceof ValidationException) {
            return $this->error('Validation failed', 422, $e->errors());
        }

        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return $this->error('Resource not found', 404);
        }

        if ($e instanceof AuthenticationException) {
            return $this->error('Unauthenticated', 401);
        }

        if ($e instanceof AuthorizationException) {
            return $this->error('Forbidden', 403);
        }

        if ($e instanceof HttpExceptionInterface) {
            return $this->error($e->getMessage() ?: 'HTTP error', $e->getStatusCode());
        }

        // Fallback: hide details unless in debug mode
        $message = config('app.debug') ? $e->getMessage() : 'Server Error';
        return $this->error($message, 500);
    }
}