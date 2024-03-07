<?php

namespace App\Listeners;

use App\NotificationUnread;
use App\NotificationSendPacs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateNotificationUnreadListener
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
        $response = [
            'uid' => $event->notifiable->uid,
            'to' => $event->channel,
            'count' => 1,
            'response' => json_encode($event->response)
        ];

        if (get_class($event->notification) == "App\\Notifications\\PatientUnreadNotification") {
            NotificationUnread::create($response);
        } else if (get_class($event->notification) == "App\\Notifications\\PatientSendPacsNotification") {
            NotificationSendPacs::create($response);
        }
    }
}
