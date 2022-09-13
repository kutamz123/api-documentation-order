<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSlackModalityPacsListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Log::channel('slack-modality-pacs')->info($event->url, [
            'method' => $event->method,
            'request' => [
                'message' => $event->request
            ],
            'response' => [
                'message' => $event->response
            ]
        ]);
    }
}
