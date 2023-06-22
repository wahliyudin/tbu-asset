<?php

namespace App\DataTransferObjects\Disposes;

use App\Http\Requests\Disposes\AssetDisposeRequest;

class AssetDisposeDto
{
    public function __construct(
        public readonly string $no_dispose,
        public readonly string $nik,
        public readonly string $nilai_buku,
        public readonly string $est_harga_pasar,
        public readonly string $notes,
        public readonly string $justifikasi,
        public readonly string $remark,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(AssetDisposeRequest $request): self
    {
        return new self(
            $request->get('no_dispose'),
            $request->get('nik'),
            $request->get('nilai_buku'),
            $request->get('est_harga_pasar'),
            $request->get('notes'),
            $request->get('justifikasi'),
            $request->get('remark'),
            $request->get('key'),
        );
    }
}