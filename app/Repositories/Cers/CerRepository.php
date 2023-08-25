<?php

namespace App\Repositories\Cers;

use App\DataTransferObjects\Cers\CerData;
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
}
