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

class LogAuthenticationToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $url, $method, $request, $response;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $method, $request, $response)
    {
        $this->url = $url;
        $this->method = $method;
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
        Log::channel('slack-auth')->info($this->url, [
            'method' => $this->method,
            'request' => $this->request,
            'response' => [
                'message' => $this->response
            ]
        ]);
    }
}
