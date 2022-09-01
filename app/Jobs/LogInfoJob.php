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

class LogInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $channel, $contain, $request, $response;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($channel, $contain, $request, $response)
    {
        $this->channel = $channel;
        $this->contain = $contain;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::channel($this->channel)->info($this->contain, [
            'request' => [
                'uid' => $this->request['uid'],
                'name' => $this->request['name'],
                'patient_id' => $this->request['patientid'],
                'mrn' => $this->request['mrn'],
                'modality' => $this->request['xray_type_code'],
                'prosedur' => $this->request['prosedur']
            ],
            'response' => [
                'true' => $this->response
            ]
        ]);
    }
}
