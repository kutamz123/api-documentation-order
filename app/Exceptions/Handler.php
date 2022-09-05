<?php

namespace App\Exceptions;

use App\Jobs\LogStackJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
            Log::info($request->getUri(), [
                'method' => $request->method(),
                'request' => [
                    'uid' => $request->uid,
                    'name' => $request->name,
                    'patient_id' => $request->patientid,
                    'mrn' => $request->mrn,
                    'modality' => $request->xray_type_code,
                    'prosedur' => $request->prosedur
                ],
                'response' => [
                    'message' => $e->getMessage()
                ]
            ]);
        });
    }
}
