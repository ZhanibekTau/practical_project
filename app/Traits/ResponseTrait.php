<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * @param string $message
     * @param mixed $data
     * @param int $errorCode
     * @param string $status
     * @return JsonResponse
     */
    public function response(
        $data = [],
        int $code = 200,
        string $message = 'Success',
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'status'  => $code,
            'data' => $data,
            'memory_get_usage' => memory_get_usage(),
        ], $code);
    }
}
