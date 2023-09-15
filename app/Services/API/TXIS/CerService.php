<?php

namespace App\Services\API\TXIS;

use App\Services\API\TXIS\Contracts\TXISService;

class CerService extends TXISService
{
    const PREFIX = '/cersdetail';

    public function url($prefix = null): string
    {
        return $this->baseUrl() . ($prefix ?? self::PREFIX);
    }

    public function getByCode($code)
    {
        return $this->get($this->url(self::PREFIX), [
            'cer_no' => $code
        ])->json();
    }

    public function getByCerItemId($cerItemId)
    {
        return $this->get($this->url(self::PREFIX), [
            'cer_item' => $cerItemId
        ])->json();
    }
}
