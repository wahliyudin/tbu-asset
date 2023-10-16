<?php

namespace App\Services\API\TXIS;

use App\DataTransferObjects\API\TXIS\BudgetTransferData;
use App\Services\API\TXIS\Contracts\TXISService;

class BudgetService extends TXISService
{
    const PREFIX = '/budgetdept';
    const SECOND_PREFIX = '/budgetdetail';

    public function url($prefix = null): string
    {
        return $this->baseUrl() . ($prefix ?? self::PREFIX);
    }

    public function all($deptcode = null)
    {
        return $this->get($this->url(), [
            'deptcode' => $deptcode
        ])->json();
    }

    public function getByCode($code)
    {
        return $this->get($this->url(self::SECOND_PREFIX), [
            'budgetcode' => $code
        ])->json();
    }

    public function sendTransfer($noTransfer, $assetId)
    {
        return $this->post($this->url('/transferbudget'), [
            'no_transfer_asset' => $noTransfer,
            'asset_id' => $assetId
        ]);
    }

    public function budgets($unitId, $projectFrom)
    {
        return $this->post($this->url('/mutasibudget/viewbudget'), [
            'unitid' => $unitId,
            'project_from' => $projectFrom,
        ]);
    }

    public function historyTransfer($noTransfer)
    {
        return $this->post($this->url('/mutasibudget/viewbudget'), [
            'no_transfer_asset' => $noTransfer,
        ]);
    }
}
