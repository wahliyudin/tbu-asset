<?php

namespace App\DataTransferObjects\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeDto;
use App\DataTransferObjects\API\HRIS\WorkflowDto;
use App\DataTransferObjects\API\TXIS\BudgetDto;
use App\Enums\Cers\Peruntukan;
use App\Enums\Cers\SumberPendanaan;
use App\Enums\Cers\TypeBudget;
use App\Http\Requests\Cers\CerRequest;
use App\Models\Cers\Cer;
use App\Services\API\HRIS\EmployeeService;
use App\Services\API\TXIS\BudgetService;
use App\Services\UserService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CerDto
{
    public function __construct(
        public readonly ?string $no_cer = null,
        public readonly ?string $nik = null,
        public readonly string|TypeBudget|null $type_budget = null,
        public readonly ?string $budget_ref = null,
        public readonly string|Peruntukan|null $peruntukan = null,
        public readonly ?string $tgl_kebutuhan = null,
        public readonly ?string $justifikasi = null,
        public readonly string|SumberPendanaan|null $sumber_pendanaan = null,
        public readonly ?string $cost_analyst = null,
        public readonly mixed $key = null,
        public readonly ?Collection $items = null,
        public readonly ?array $itemsToAttach = null,
        public readonly ?EmployeeDto $employee = null,
        public readonly ?Collection $workflows = null,
        public readonly ?BudgetDto $budget = null,
    ) {
    }

    public static function fromRequest(CerRequest $request): self
    {
        return new self(
            Str::random(),
            auth()->user()?->nik,
            $request->get('type_budget'),
            $request->get('budget_ref'),
            $request->get('peruntukan'),
            $request->get('tgl_kebutuhan'),
            $request->get('justifikasi'),
            $request->get('sumber_pendanaan'),
            $request->get('cost_analyst'),
            $request->get('key'),
            CerItemDto::fromArray($request->get('items')),
            CerItemDto::fromArrayToAttach($request->get('items')),
        );
    }

    public static function fromModel(Cer $cer)
    {
        $cer->loadMissing(['workflow', 'workflows']);
        return new self(
            $cer->no_cer,
            $cer->nik,
            $cer->type_budget,
            $cer->budget_ref,
            $cer->peruntukan,
            $cer->tgl_kebutuhan,
            $cer->justifikasi,
            $cer->sumber_pendanaan,
            $cer->cost_analyst,
            $cer->getKey(),
            CerItemDto::fromCollection($cer->items),
            null,
            EmployeeDto::fromResponse((new EmployeeService)->getByNik($cer->nik)),
            WorkflowDto::fromModel($cer),
            BudgetDto::formResponse((new BudgetService)->getByCode($cer->budget_ref))
        );
    }

    public static function fromModelThroughApi(Cer $cer)
    {
        return new self(
            $cer->no_cer,
            $cer->nik,
            $cer->type_budget,
            $cer->budget_ref,
            $cer->peruntukan,
            $cer->tgl_kebutuhan,
            $cer->justifikasi,
            $cer->sumber_pendanaan,
            $cer->cost_analyst,
            $cer->getKey(),
            CerItemDto::fromCollection($cer->items),
            null,
            EmployeeDto::fromResponse((new EmployeeService)->setToken(UserService::getAdministrator()?->oatuhToken?->access_token)->getByNik($cer->nik)),
            null,
            BudgetDto::formResponse((new BudgetService)->getByCode($cer->budget_ref))
        );
    }
}
