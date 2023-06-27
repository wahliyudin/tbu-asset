<?php

namespace App\DataTransferObjects\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeDto;
use App\DataTransferObjects\API\HRIS\WorkflowDto;
use App\Enums\Cers\Peruntukan;
use App\Enums\Cers\SumberPendanaan;
use App\Enums\Cers\TypeBudget;
use App\Http\Requests\Cers\CerRequest;
use App\Models\Cers\Cer;
use App\Services\API\HRIS\EmployeeService;
use Illuminate\Support\Collection;

class CerDto
{
    public function __construct(
        public readonly string $no_cer,
        public readonly string $nik,
        public readonly string|TypeBudget $type_budget,
        public readonly ?string $budget_ref,
        public readonly string|Peruntukan $peruntukan,
        public readonly string $tgl_kebutuhan,
        public readonly string $justifikasi,
        public readonly string|SumberPendanaan $sumber_pendanaan,
        public readonly string $cost_analyst,
        public readonly mixed $key = null,
        public readonly ?Collection $items,
        public readonly ?array $itemsToAttach,
        public readonly ?EmployeeDto $employee = null,
        public readonly ?Collection $workflows = null,
    ) {
    }

    public static function fromRequest(CerRequest $request): self
    {
        return new self(
            'example',
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
            WorkflowDto::fromModel($cer)
        );
    }
}
