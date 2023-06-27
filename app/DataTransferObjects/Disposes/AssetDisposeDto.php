<?php

namespace App\DataTransferObjects\Disposes;

use App\DataTransferObjects\API\HRIS\EmployeeDto;
use App\DataTransferObjects\API\HRIS\WorkflowDto;
use App\DataTransferObjects\Assets\AssetDto;
use App\Enums\Disposes\Dispose\Pelaksanaan;
use App\Helpers\Helper;
use App\Http\Requests\Disposes\AssetDisposeRequest;
use App\Models\Disposes\AssetDispose;
use App\Services\API\HRIS\EmployeeService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AssetDisposeDto
{
    public function __construct(
        public readonly string|null $asset_id = null,
        public readonly string|null $no_dispose = null,
        public readonly string|null $nik = null,
        public readonly int|null $nilai_buku = null,
        public readonly int|null $est_harga_pasar = null,
        public readonly string|null $notes = null,
        public readonly string|null $justifikasi = null,
        public readonly string|null $remark = null,
        public readonly Pelaksanaan|string|null $pelaksanaan = null,
        public readonly mixed $key = null,
        public readonly ?AssetDto $assetDto = null,
        public readonly ?EmployeeDto $employee = null,
        public readonly ?Collection $workflows = null,
    ) {
    }

    public static function fromRequest(AssetDisposeRequest $request): self
    {
        return new self(
            $request->get('asset'),
            Str::random(),
            auth()->user()->nik,
            Helper::resetRupiah($request->get('nilai_buku')),
            Helper::resetRupiah($request->get('est_harga_pasar')),
            $request->get('notes'),
            $request->get('justifikasi'),
            $request->get('remark'),
            $request->get('pelaksanaan'),
            $request->get('key'),
        );
    }

    public static function fromModel(AssetDispose $assetDispose)
    {
        $assetDispose->loadMissing(['workflow', 'workflows']);
        return new self(
            $assetDispose->asset_id,
            $assetDispose->no_dispose,
            $assetDispose->nik,
            $assetDispose->nilai_buku,
            $assetDispose->est_harga_pasar,
            $assetDispose->notes,
            $assetDispose->justifikasi,
            $assetDispose->remark,
            $assetDispose->pelaksanaan,
            $assetDispose->getKey(),
            AssetDto::fromModel($assetDispose->asset),
            EmployeeDto::fromResponse((new EmployeeService)->getByNik($assetDispose->nik)),
            WorkflowDto::fromModel($assetDispose)
        );
    }
}
