<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class AppException extends Exception
{
    protected array $errors;

    public function __construct(
        string $message = 'Validation Error',
        int $code = 422,
        ?Exception $previous = null,
        array $errors = []
    ) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'errors' => $this->errors,
            'code' => $this->getCode(),
        ], $this->getCode());
    }
}
