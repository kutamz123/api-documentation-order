<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModalityPacsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $url, $method = 'PUT', $request = 'Scheduler EveryOneMinute', $response;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($url, $response)
    {
        $this->url = $url;
        $this->response = $response;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
