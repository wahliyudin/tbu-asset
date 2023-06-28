<?php

namespace App\Services\Cers;

use App\DataTransferObjects\Cers\CerDto;
use App\Enums\Workflows\Status;
use App\Http\Requests\Cers\CerRequest;
use App\Models\Cers\Cer;
use App\Repositories\Cers\CerRepository;
use Illuminate\Http\Request;

class CerService
{
    public function __construct(
        protected CerRepository $cerRepository,
    ) {
    }

    public function all()
    {
        return Cer::query()->get();
    }

    public function updateOrCreate(CerRequest $request)
    {
        $dto = CerDto::fromRequest($request);
        $cer = $this->cerRepository->updateOrCreate($dto);
        $cer->items()->delete();
        $cer->items()->createMany($dto->itemsToAttach);
        $cer->workflows()->delete();
        CerWorkflowService::setModel($cer)->store();
    }

    public function delete(Cer $cer)
    {
        $cer->items()->delete();
        $cer->workflows()->delete();
        return $cer->delete();
    }

    public function getListNoCerByUser(Request $request)
    {
        return Cer::query()->where('status', Status::CLOSE)->when($request->nik, function ($query, $nik) {
            $query->where('nik', $nik);
        })->when($request->email, function ($query, $email) {
            $query->whereHas('user', function ($query) use ($email) {
                $query->where('email', $email);
            });
        })->pluck('no_cer');
    }

    public function findByNo($no)
    {
        return Cer::query()->with('items')->where('no_cer', $no)->firstOrFail();
    }
}