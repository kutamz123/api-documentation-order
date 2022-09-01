<?php

namespace App\Http\Middleware;

use App\Jobs\LogInfoJob;
use Closure;

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

        LogInfoJob::dispatch('daily', $request->getUri(), $request->all(), $response->getContent());

        return $response;
    }
}
