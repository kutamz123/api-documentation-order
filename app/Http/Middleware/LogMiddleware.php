<?php

namespace App\Http\Middleware;

use App\Events\MiddlewareEvent;
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

        MiddlewareEvent::dispatch($request->getUri(), $request->method(), $request->all(), $response->content());

        return $response;
    }
}
