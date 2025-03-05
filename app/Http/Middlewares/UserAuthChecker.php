<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserAuthChecker
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return ResponseFactory|Application|Response|mixed|object
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->header('User-Id')) {
            return $next($request);
        }

        return response(['status' => 'error', 'message' => 'missing header User-Id'], 401);
    }
}
