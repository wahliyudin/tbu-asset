<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\DealerData;
use App\Http\Requests\Masters\DealerStoreRequest;
use App\Facades\Elasticsearch;
use App\Models\Masters\Dealer;
use Illuminate\Support\Facades\DB;

class DealerService
{
    public function all($search = null, $length = 50)
    {
        return Elasticsearch::setModel(Dealer::class)->searchMultiMatch($search, $length)->all();
    }

    public static function dataForSelect(...$others)
    {
        return Dealer::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate(DealerStoreRequest $request)
    {
        $data = DealerData::from($request->all());
        return DB::transaction(function () use ($data) {
            $dealer = Dealer::query()->updateOrCreate([
                'id' => $data->key
            ], $data->toArray());
            $this->sendToElasticsearch($dealer, $data->getKey());
            return $dealer;
        });
    }

    public function delete(Dealer $dealer)
    {
        return DB::transaction(function () use ($dealer) {
            Elasticsearch::setModel(Dealer::class)->deleted(DealerData::from($dealer));
            return $dealer->delete();
        });
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
