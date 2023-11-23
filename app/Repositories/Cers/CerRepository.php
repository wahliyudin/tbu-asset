<?php

namespace App\Repositories\Cers;

use App\DataTransferObjects\Cers\CerData;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Cers\Cer;

class CerRepository
{
    public function updateOrCreate(CerData $data)
    {
        return Cer::query()->updateOrCreate([
            'id' => $data->id
        ], $data->toArray());
    }

    public static function storeWorkflow()
    {
    }

    public function sendToElasticsearch(Cer $cer, $key)
    {
        $cer->load(['items', 'workflows']);
        return Message::updateOrCreate(Topic::ASSET_REQUEST, $cer->getKey(), $cer->toArray());
    }

    public function destroyFromElastic(Cer $cer)
    {
        return Message::deleted(Topic::ASSET_REQUEST, 'id', $cer->getKey(), Nested::ASSET_REQUEST);
    }
}
