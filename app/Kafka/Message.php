<?php

namespace App\Kafka;

use App\Jobs\Kafka\SendTopic;
use App\Kafka\Enums\Action;
use Junges\Kafka\Message\Message as KafkaMessage;

class Message
{
    public function updateOrCreate(string $topic, mixed $id, array $data)
    {
        $message = new KafkaMessage(
            body: [
                'id' => $id,
                'data' => $data
            ],
            key: Action::UPDATE_OR_CREATE,
        );
        dispatch(new SendTopic($topic, $message));
    }

    public function updated(string $topic, string $key, mixed $value, string $object, array $data)
    {
        $message = new KafkaMessage(
            body: [
                'key' => $key,
                'value' => $value,
                'object' => $object,
                'data' => $data
            ],
            key: Action::UPDATED,
        );
        dispatch(new SendTopic($topic, $message));
    }

    public function deleted(string $topic, mixed $id)
    {
        $message = new KafkaMessage(
            body: [
                'id' => $id,
            ],
            key: Action::DELETED,
        );
        dispatch(new SendTopic($topic, $message));
    }
}
