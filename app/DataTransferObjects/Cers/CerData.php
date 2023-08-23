<?php

namespace App\DataTransferObjects\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\API\TXIS\BudgetData;
use App\DataTransferObjects\WorkflowData;
use App\Enums\Cers\Peruntukan;
use App\Enums\Cers\SumberPendanaan;
use App\Enums\Cers\TypeBudget;
use App\Services\API\TXIS\BudgetService;
use App\Services\GlobalService;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Illuminate\Support\Str;

class CerData extends Data
{
    public function __construct(
        public ?string $no_cer = null,
        public ?string $nik = null,
        public string|TypeBudget|null $type_budget = null,
        public ?string $budget_ref = null,
        public string|Peruntukan|null $peruntukan = null,
        public ?string $tgl_kebutuhan = null,
        public ?string $justifikasi = null,
        public string|SumberPendanaan|null $sumber_pendanaan = null,
        public ?string $cost_analyst = null,
        public ?string $id = null,
        #[DataCollectionOf(CerItemData::class)]
        public ?DataCollection $items,
        #[DataCollectionOf(WorkflowData::class)]
        public ?DataCollection $workflows,
        public ?EmployeeData $employee,
        public ?BudgetData $budget,
    ) {
        $this->setDefaultValue();
        $this->employee = EmployeeData::from(GlobalService::getEmployee($this->nik, true));
        $this->budget = BudgetData::fromApi(GlobalService::getBudgetByCode($this->budget_ref));
    }

    private function setDefaultValue()
    {
        if (is_null($this->no_cer)) {
            $this->no_cer = Str::random();
        }
        if (is_null($this->nik)) {
            $this->nik = auth()->user()->nik;
        }
    }

    public function itemsToAttach(): array
    {
        return $this->items->toArray();
    }
}
