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

class LogSimrsRisJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $status, $contain, $request, $response;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($status, $contain, $request, $response)
    {
        $this->status = $status;
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
        $context = [
            'request' => $this->request,
            'response' => $this->response
        ];

        if ($this->status == 'true') {
            Log::channel('slack-simrs-ris-success')->info($this->contain, $context);
        } else if ($this->status == 'false') {
            Log::channel('slack-simrs-ris-error')->critical($this->contain, $context);
        }
    }
}
