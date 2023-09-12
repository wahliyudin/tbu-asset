<?php

namespace App\Services\Cers;

use App\DataTransferObjects\Cers\CerData;
use App\Enums\Workflows\Module;
use App\Enums\Workflows\Status;
use App\Facades\Elasticsearch;
use App\Models\Cers\Cer;
use App\Services\Workflows\Workflow;
use Illuminate\Database\Eloquent\Model;

class CerWorkflowService extends Workflow
{
    public static function setModel(Cer $cer, Module $module = Module::CER_HO)
    {
        return new self($cer, $module);
    }

    protected function handleStoreWorkflow()
    {
    }

    protected function handleIsLastAndApprov()
    {
    }

    protected function handleIsNotLastAndApprov()
    {
    }

    protected function handleIsRejected()
    {
    }

    protected function changeStatus(Model $cer, Status $status)
    {
        $cer->load(['items', 'workflows']);
        $data = CerData::from(array_merge($cer->toArray(), ['status' => $status->value]));
        return Elasticsearch::setModel(Cer::class)->updated($data);
    }
}
