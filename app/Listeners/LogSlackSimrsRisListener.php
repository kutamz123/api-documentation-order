<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSlackSimrsRisListener implements ShouldQueue
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

        $contain = [
            'method' => $event->method,
            'request' => $event->request,
            'response' => [
                'message' => $event->response
            ]
        ];

        if ($event->bool == 'true') {
            Log::channel('slack-simrs-ris-success')->info($event->url, $contain);
        } else if ($event->bool == 'false') {
            Log::channel('slack-simrs-ris-error')->critical($event->url, $contain);
        }
    }
}
