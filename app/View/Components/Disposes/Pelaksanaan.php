<?php

namespace App\View\Components\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Pelaksanaan extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?AssetDisposeData $assetDispose,
        public string $type,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.disposes.pelaksanaan');
    }
}