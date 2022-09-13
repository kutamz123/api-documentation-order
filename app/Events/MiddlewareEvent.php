<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MiddlewareEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $url, $method, $request, $response;

    /**
     * Create a new event instance.
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
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
