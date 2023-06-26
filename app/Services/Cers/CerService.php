<?php

namespace App\Services\Cers;

use App\DataTransferObjects\Cers\CerDto;
use App\Http\Requests\Cers\CerRequest;
use App\Models\Cers\Cer;
use App\Repositories\Cers\CerRepository;

class CerService
{
    public function __construct(
        protected CerRepository $cerRepository
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
        $cer->items()->sync($dto->itemsToAttach);
    }

    public function delete(Cer $cer)
    {
        return $cer->delete();
    }
}
