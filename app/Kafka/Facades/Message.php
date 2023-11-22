<?php

namespace App\Kafka\Facades;

use App\Elasticsearch\QueryBuilder\Nested;
use Illuminate\Support\Facades\Facade;
use App\Kafka\Enums\Topic;

/**
 * @mixin \App\Kafka\Message
 *
 * @method static void updateOrCreate(Topic $topic, mixed $id, array $data)
 * @method static void updated(Topic $topic, string $key, mixed $value, Nested $object, array $data)
 * @method static void deleted(Topic $topic, string $key, mixed $value, Nested $object)
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
