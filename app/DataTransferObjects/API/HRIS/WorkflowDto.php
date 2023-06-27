<?php

namespace App\DataTransferObjects\API\HRIS;

use App\Enums\Workflows\LastAction;
use App\Interfaces\ModelWithWorkflowInterface;
use App\Services\API\HRIS\EmployeeService;
use Illuminate\Support\Collection;

class WorkflowDto
{
    public function __construct(
        public readonly ?int $sequence,
        public readonly ?int $nik,
        public readonly ?string $title,
        public readonly ?LastAction $lastAction,
        public readonly ?string $lastActionDate,
        public readonly ?EmployeeDto $employee,
    ) {
    }

    public static function fromModel(ModelWithWorkflowInterface $model): Collection
    {
        $results = [];
        foreach ($model->workflows as $workflow) {
            $results = array_merge($results, [
                new self(
                    $workflow?->sequence,
                    $workflow?->nik,
                    $workflow?->title,
                    $workflow?->last_action,
                    $workflow?->last_action_date,
                    EmployeeDto::fromResponse((new EmployeeService)->getByNik($workflow?->nik)),
                )
            ]);
        }
        return collect($results);
    }

    public static function fromResponseMultiple(array $response): Collection
    {
        $results = [];
        foreach ($response as $key => $value) {
            $results = array_merge($results, [
                new self(
                    $value['sequence'],
                    $value['nik'],
                    $value['title'],
                    LastAction::getByValue($value['last_action']),
                    $value['last_action_date'],
                    null,
                )
            ]);
        }
        return collect($results);
    }
}
