<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogMiddleware
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
        $response = $next($request);

        Log::info($request->getUri(), [
            'method' => $request->method(),
            'request' => $request->all(),
            'response' => $response->content()
        ]);

        return $response;
    }
}
