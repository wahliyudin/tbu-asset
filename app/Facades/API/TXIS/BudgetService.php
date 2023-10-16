<?php

namespace App\Facades\API\TXIS;

use App\DataTransferObjects\API\TXIS\BudgetTransferData;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\API\TXIS\BudgetService
 *
 * @method static \Illuminate\Http\Client\Response sendTransfer($noTransfer, $assetId)
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
