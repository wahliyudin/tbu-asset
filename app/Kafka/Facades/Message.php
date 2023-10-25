<?php

namespace App\Kafka\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Kafka\Message
 *
 * @method static void updateOrCreate(string $topic, mixed $id, array $data)
 * @method static void updated(string $topic, string $key, mixed $value, string $object, array $data)
 * @method static void deleted(string $topic, mixed $id)
 *
 * @see \App\Kafka\Message
 */
class Message extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kafka_message';
    }
}
