<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;

class RequestValidationFormatter
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        if ($response->getStatusCode() == 422) {
            $content = json_decode($response->content(), true);

            if ($content && isset($content['message'], $content['errors'])) {
                $out = [
                    'status' => 'error',
                    'message' => 'Invalid request payload',
                    'detail' => $content['errors'],
                ];
                $response->setContent(json_encode($out, JSON_UNESCAPED_UNICODE));
            }
        }

        return $response;
    }
}
