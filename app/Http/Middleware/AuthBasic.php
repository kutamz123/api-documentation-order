<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\FormatResponse;

class AuthBasic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->expectsJson())
            return FormatResponse::error(null, "Request header harus application/json", 404);
        else if (!$request->bearerToken())
            return FormatResponse::error(null, "masukkan bearertoken", 401);
        else
            return $next($request);
    }
}
