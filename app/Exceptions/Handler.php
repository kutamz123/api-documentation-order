<?php

namespace App\Exceptions;

use App\Events\AuthenticationEvent;
use Illuminate\Database\QueryException;
use App\Http\Controllers\API\FormatResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // Log Simrs request API -> authenticated
        $this->renderable(function (AuthenticationException $e, $request) {
            AuthenticationEvent::dispatch($request->getUri(), $request->method(), $request->all(), $e->getMessage());
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return FormatResponse::exception(404, "error", "NotFoundHttpException / (Url tidak ditemukan)");
        });

        $this->renderable(function (QueryException $e, $request) {
            return FormatResponse::exception(500, "error", "QueryException / (Kesalahan pada query parameter)");
        });
    }
}
