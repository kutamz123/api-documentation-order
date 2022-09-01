<?php

namespace App\Jobs;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class LogStackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::stack(['daily', 'slack-auth'])->info('Unauthenticated', [
            'request' => [
                'uid' => $this->request['uid'],
                'name' => $this->request['name'],
                'patientid' => $this->request['patientid'],
                'mrn' => $this->request['mrn'],
                'modality' => $this->request['xray_type_code'],
                'prosedur' => $this->request['prosedur']
            ],
            'response' => ['message' => 'unauthenticated']
        ]);
    }
}
