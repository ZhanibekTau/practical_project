<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    public function render($request, Throwable $e)
    {
        if ($request->get('dd')) {
            return parent::render($request, $e);
        }

        if ($e instanceof AppException) {
            return $e->render();
        }

        $statusCode = $this->getStatusCode($e);

        $appException = new AppException(
            $e->getMessage() ?: Response::$statusTexts[$statusCode] ?? 'Unknown Error',
            $statusCode
        );

        return $appException->render();
    }

    /**
     * @param Throwable $exception
     *
     * @return int
     */
    protected function getStatusCode(Throwable $exception): int
    {
        if ($exception instanceof HttpException) {
            return $exception->getStatusCode();
        }

        if ($exception instanceof ValidationException) {
            return Response::HTTP_UNPROCESSABLE_ENTITY; // 422
        }

        if ($exception instanceof ModelNotFoundException) {
            return Response::HTTP_NOT_FOUND; // 404
        }

        if ($exception instanceof AuthorizationException) {
            return Response::HTTP_FORBIDDEN; // 403
        }

        if ($exception instanceof AuthenticationException) {
            return Response::HTTP_UNAUTHORIZED; // 403
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR; // 500
    }
}
