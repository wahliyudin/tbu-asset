<?php

namespace App\Services\API\TXIS;

use App\Services\API\TXIS\Contracts\TXISService;

class BudgetService extends TXISService
{
    const PREFIX = '/budgetdept';
    const SECOND_PREFIX = '/budgetdetail';

    public function url($prefix = null): string
    {
        return $this->baseUrl() . ($prefix ?? self::PREFIX);
    }

    public function all()
    {
        return $this->get($this->url(), [
            'deptcode' => 'PNL99'
        ])->json();
    }

    public function getByCode($code)
    {
        return $this->get($this->url(self::SECOND_PREFIX), [
            'budgetcode' => $code
        ])->json();
    }
}
