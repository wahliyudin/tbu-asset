<?php

namespace App\Repositories\Assets;

use App\DataTransferObjects\Assets\AssetData;
use App\Models\Assets\Asset;

class AssetRepository
{
    public function updateOrCreate(AssetData $data)
    {
        return Asset::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
    }
}
