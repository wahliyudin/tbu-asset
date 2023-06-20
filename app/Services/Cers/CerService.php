<?php

namespace App\Services\Cers;

use App\DataTransferObjects\Cers\CerDto;
use App\Models\Cers\Cer;
use App\Repositories\Cers\CerRepository;
use Illuminate\Http\Request;

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

    public function updateOrCreate(Request $request)
    {
        $cer = $this->cerRepository->updateOrCreate(CerDto::fromRequest($request));
    }

    public function delete(Cer $cer)
    {
        return $cer->delete();
    }
}
