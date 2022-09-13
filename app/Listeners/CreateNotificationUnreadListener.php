<?php

namespace App\Listeners;

use App\NotificationUnread;
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
        NotificationUnread::create([
            'uid' => $event->notifiable->uid,
            'to' => $event->channel,
            'count' => 1
        ]);
    }
}
