<?php

namespace App\Http\Middleware;

use App\Events\MiddlewareEvent;
use Closure;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        $streamDownload = new StreamedResponse();

        $content = 'default';

        if ($streamDownload instanceof $streamDownload) {
            $content = 'akses log file';
        } else {
            $content = $response->content();
        }

        MiddlewareEvent::dispatch($request->getUri(), $request->method(), $request->all(), $content);

        return $response;
    }
}
