<?php

namespace App\DataTransferObjects\Cers;

use App\DataTransferObjects\API\HRIS\DepartmentData;
use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\API\TXIS\BudgetData;
use App\DataTransferObjects\WorkflowData;
use App\Enums\Cers\Peruntukan;
use App\Enums\Cers\SumberPendanaan;
use App\Enums\Cers\TypeBudget;
use App\Enums\Workflows\Status;
use App\Helpers\AuthHelper;
use App\Helpers\Helper;
use App\Interfaces\DataInterface;
use App\Models\Cers\Cer;
use App\Services\API\TXIS\BudgetService;
use App\Services\Cers\CerService;
use App\Services\GlobalService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        public ?string $department_id = null,
        public ?string $tgl_kebutuhan = null,
        public ?string $justifikasi = null,
        public SumberPendanaan|null $sumber_pendanaan = null,
        public ?string $cost_analyst = null,
        public ?string $deptcode = null,
        public ?string $file_ucr = null,
        public ?Status $status = null,
        public ?string $id = null,
        #[DataCollectionOf(CerItemData::class)]
        public ?DataCollection $items,
        #[DataCollectionOf(WorkflowData::class)]
        public ?DataCollection $workflows,
        public ?EmployeeData $employee,
        public ?DepartmentData $department,
        public ?BudgetData $budget,
    ) {
        $this->setDefaultValue();
        if (!isset($this->employee)) {
            $this->employee = EmployeeData::from(GlobalService::getEmployee($this->nik, false));
        }
        if (isset($this->budget_ref)) {
            $this->budget = BudgetData::fromApi(GlobalService::getBudgetByCode($this->budget_ref));
        }
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

    public static function fromRequest(Request $request, bool $isDraft = false)
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
        $id = $request->id;
        $cer = null;
        $noCer = null;
        if (!$id) {
            $noCer = CerService::nextNoCer($request->department_id, AuthHelper::getNik());
        } else {
            $cer = Cer::query()->find($id);
        }
        if ($id && $request->hasFile('file_ucr')) {
            Storage::disk('public')->delete($cer?->file_ucr);
        }
        $file_ucr = self::storeFile($request->file('file_ucr'), $noCer);
        $additional = [
            'items' => $items,
            'file_ucr' => $file_ucr,
            'no_cer' => $id ? $cer?->no_cer : $noCer,
            'status' => $isDraft ? Status::DRAFT : Status::OPEN
        ];
        $self = self::from(array_merge($request->toArray(), $additional));
        if (!$file_ucr) {
            return $self->except('file_ucr');
        }
        return $self;
    }

    public static function storeFile(?UploadedFile $uploadedFile, $noCer)
    {
        if (!$uploadedFile) {
            return null;
        }
        $folder = 'cers';
        if (count(Storage::disk('public')->allDirectories($folder)) > 0) {
            Storage::disk('public')->makeDirectory($folder);
        }
        $fileName = $noCer . '-' . time() . '.' . $uploadedFile->getClientOriginalExtension();
        $uploadedFile->storeAs("public/$folder", $fileName);
        return $folder . '/' . $fileName;
    }

    public function itemsToAttach(): array
    {
        return $this->items->toArray();
    }

    public function grandTotal()
    {
        return $this->items->toCollection()->sum(function (CerItemData $cerItemData) {
            return $cerItemData->qty * $cerItemData->price;
        });
    }

    public function getKey(): string|null
    {
        return $this->id;
    }
}
