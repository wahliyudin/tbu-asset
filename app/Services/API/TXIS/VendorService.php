<?php

namespace App\Services\API\TXIS;

use App\Services\API\TXIS\Contracts\TXISService;

class VendorService extends TXISService
{
    const PREFIX = '/vendor';

    public function url($prefix = null): string
    {
        return $this->baseUrl() . ($prefix ?? self::PREFIX);
    }

    public function all()
    {
        return $this->get($this->url(), [])
            ->json();
    }

    public function getById($id)
    {
        return $this->get($this->url(), [$id])
            ->json();
    }
}
