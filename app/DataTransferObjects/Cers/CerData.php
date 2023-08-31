<?php

namespace App\DataTransferObjects\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\API\TXIS\BudgetData;
use App\DataTransferObjects\WorkflowData;
use App\Enums\Cers\Peruntukan;
use App\Enums\Cers\SumberPendanaan;
use App\Enums\Cers\TypeBudget;
use App\Enums\Workflows\Status;
use App\Helpers\Helper;
use App\Interfaces\DataInterface;
use App\Services\API\TXIS\BudgetService;
use App\Services\GlobalService;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Illuminate\Support\Str;

class CerData extends Data implements DataInterface
{
    public function __construct(
        public ?string $no_cer = null,
        public ?string $nik = null,
        public TypeBudget|null $type_budget = null,
        public ?string $budget_ref = null,
        public Peruntukan|null $peruntukan = null,
        public ?string $tgl_kebutuhan = null,
        public ?string $justifikasi = null,
        public SumberPendanaan|null $sumber_pendanaan = null,
        public ?string $cost_analyst = null,
        public ?string $deptcode = null,
        public ?Status $status = null,
        public ?string $id = null,
        #[DataCollectionOf(CerItemData::class)]
        public ?DataCollection $items,
        #[DataCollectionOf(WorkflowData::class)]
        public ?DataCollection $workflows,
        public ?EmployeeData $employee,
        public ?BudgetData $budget,
    ) {
        $this->setDefaultValue();
        $this->employee = EmployeeData::from(GlobalService::getEmployee($this->nik, false));
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

    public static function fromRequest(Request $request)
    {
        $items = [];
        for ($i = 0; $i < count($request->items); $i++) {
            $items[] = [
                'description' => $request->items[$i]['description'],
                'model' => $request->items[$i]['model'],
                'est_umur' => $request->items[$i]['est_umur'],
                'qty' => $request->items[$i]['qty'],
                'price' => Helper::resetRupiah($request->items[$i]['price']),
                'uom_id' => $request->items[$i]['uom_id'],
            ];
        }

        return self::from(array_merge($request->toArray(), ['items' => $items, 'status' => Status::OPEN]));
    }

    public function itemsToAttach(): array
    {
        return $this->items->toArray();
    }

    public function getKey(): string|null
    {
        return $this->id;
    }
}
