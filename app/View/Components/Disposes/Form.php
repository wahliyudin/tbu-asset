<?php

namespace App\View\Components\Disposes;

use App\Models\Disposes\AssetDispose;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?AssetDispose $assetDispose
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.disposes.form');
    }
}
