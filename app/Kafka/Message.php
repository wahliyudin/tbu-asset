<?php

namespace App\Kafka;

use App\Jobs\Kafka\SendTopic;
use App\Kafka\Enums\Action;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use Junges\Kafka\Message\Message as KafkaMessage;

class Message
{
    public function updateOrCreate(Topic $topic, mixed $id, array $data)
    {
        $message = new KafkaMessage(
            body: [
                'id' => $id,
                'data' => $data
            ],
            key: Action::UPDATE_OR_CREATE->value,
        );
        dispatch(new SendTopic($topic->value, $message));
    }

    public function updated(Topic $topic, string $key, mixed $value, Nested $object, array $data)
    {
        $message = new KafkaMessage(
            body: [
                'key' => $key,
                'value' => $value,
                'object' => $object->value,
                'data' => $data
            ],
            key: Action::UPDATED->value,
        );
        dispatch(new SendTopic($topic->value, $message));
    }

    public function deleted(Topic $topic, string $key, mixed $value, Nested $object)
    {
        $message = new KafkaMessage(
            body: [
                'key' => $key,
                'value' => $value,
                'object' => $object->value,
            ],
            key: Action::DELETED->value,
        );
        dispatch(new SendTopic($topic->value, $message));
    }
}
