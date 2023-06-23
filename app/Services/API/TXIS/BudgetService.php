<?php

namespace App\Services\API\TXIS;

use App\DataTransferObjects\API\TXIS\BudgetDto;
use App\Services\API\TXIS\Contracts\TXISService;

class BudgetService extends TXISService
{
    const PREFIX = '/budgets';

    public function url(): string
    {
        return $this->baseUrl() . self::PREFIX;
    }

    public function all()
    {
        return BudgetDto::fromResponseMultiple($this->get($this->url())->json());
    }

    public function getById($id)
    {
        return $this->get($this->extendUrl($id))->json();
    }
}