<?php

namespace App\View\Components\Assets;

use App\DataTransferObjects\Assets\AssetData;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Detail extends Component
{
    public string $umurAsset;
    public string $umurPakai;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public AssetData $asset,
        public bool $withQrCode = true
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $tglPO = $this->asset->leasing?->tanggal_perolehan;
        $tglBast = $this->asset->tgl_bast;
        $tglPO = isset($tglPO) ? Carbon::parse($tglPO) : null;
        $this->umurAsset = now()->diffInMonths($tglPO);
        $this->umurPakai = now()->diffInMonths($tglBast);
        return view('components.assets.detail');
    }
}
