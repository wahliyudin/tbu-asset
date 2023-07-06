<?php

namespace App\Repositories\API\TXIS;

use App\DataTransferObjects\API\TXIS\BudgetData;
use App\Services\API\TXIS\Contracts\TXISService;

class BudgetRepository extends TXISService
{
    const PREFIX = '/budgetdetails';

    public function url(): string
    {
        return $this->baseUrl() . self::PREFIX;
    }

    public function all()
    {
        $budget = $this->get($this->url(), [
            'deptcode' => 'PNL99'
        ])->json();
        return BudgetData::collection(isset($budget['data']) ? $budget['data'] : [])->toCollection();
    }

    public function getById($id)
    {
        return $this->get($this->extendUrl($id))->json();
    }
}
