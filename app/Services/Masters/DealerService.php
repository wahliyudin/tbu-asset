<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\DealerData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Dealer;

class DealerService
{
    public function all($search = null)
    {
        return Elasticsearch::setModel(Dealer::class)->searchQueryString($search, 50)->all();
    }

    public function updateOrCreate(DealerData $data)
    {
        $dealer = Dealer::query()->updateOrCreate([
            'id' => $data->getKey()
        ], [
            'name' => $data->name,
        ]);
        $this->sendToElasticsearch($dealer, $data->getKey());
        return $dealer;
    }

    public function delete(Dealer $dealer)
    {
        Elasticsearch::setModel(Dealer::class)->deleted(DealerData::from($dealer));
        return $dealer->delete();
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(Dealer::class)->find($id)->asArray();
        return $asset['_source'];
    }

    private function sendToElasticsearch(Dealer $cluster, $key)
    {
        if ($key) {
            return Elasticsearch::setModel(Dealer::class)->updated(DealerData::from($cluster));
        }
        return Elasticsearch::setModel(Dealer::class)->created(DealerData::from($cluster));
    }
}
