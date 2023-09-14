<?php

namespace App\View\Components\Assets;

use App\DataTransferObjects\Assets\AssetData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Detail extends Component
{
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
        return view('components.assets.detail');
    }
}
