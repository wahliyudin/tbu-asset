<?php

namespace App\Websockets;


use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Websockets\Pusher\PusherBrodcast
 *
 * @method static \Illuminate\Broadcasting\BroadcastException send(string $channel, string $event, array $payload)
 *
 * @see \App\Websockets\Pusher\PusherBrodcast
 */
class PusherBrodcast extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pusher_websocket';
    }
}
