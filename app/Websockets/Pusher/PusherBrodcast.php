<?php

namespace App\Websockets\Pusher;

use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Pusher\Pusher;

class PusherBrodcast
{
    public function init()
    {
        $pusher = $this->pusher();
        return new PusherBroadcaster($pusher);
    }

    public function pusher()
    {
        return new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            config('broadcasting.connections.pusher.options', [])
        );
    }

    public function send(string $channel, string $event, array $payload)
    {
        return $this->init()->broadcast(
            [$channel],
            $event,
            $payload
        );
    }
}
