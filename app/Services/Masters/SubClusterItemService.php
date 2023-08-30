<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\SubClusterItemData;
use App\Http\Requests\Masters\SubClusterItemStoreRequest;
use App\Facades\Elasticsearch;
use App\Models\Masters\SubClusterItem;

class SubClusterItemService
{
    public function all($search = null)
    {
        return Elasticsearch::setModel(SubClusterItem::class)->searchMultiMatch($search, 50)->all();
    }

    public function updateOrCreate(SubClusterItemStoreRequest $request)
    {
        $data = SubClusterItemData::from($request->all());
        $subClusterItem = SubClusterItem::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
        $this->sendToElasticsearch($subClusterItem, $data->getKey());
        return $subClusterItem;
    }

    public function delete(SubClusterItem $subClusterItem)
    {
        Elasticsearch::setModel(SubClusterItem::class)->deleted(SubClusterItemData::from($subClusterItem));
        return $subClusterItem->delete();
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(SubClusterItem::class)->find($id)->asArray();
        return $asset['_source'];
    }

    private function sendToElasticsearch(SubClusterItem $subClusterItem, $key)
    {
        $subClusterItem->load(['subCluster.cluster.category']);
        if ($key) {
            return Elasticsearch::setModel(SubClusterItem::class)->updated(SubClusterItemData::from($subClusterItem));
        }
        return Elasticsearch::setModel(SubClusterItem::class)->created(SubClusterItemData::from($subClusterItem));
    }
}
