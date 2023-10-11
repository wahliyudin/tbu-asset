<?php

namespace App\Facades;

use App\DataTransferObjects\API\TXIS\BudgetTransferData;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\API\TXIS\BudgetService
 *
 * @method static \App\Services\API\TXIS\BudgetService sendTransfer(BudgetTransferData $data)
 *
 * @see \App\Services\API\TXIS\BudgetService
 */
class BudgetService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'txis_budget_service';
    }
}
