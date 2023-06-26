<?php

namespace App\View\Components\Transfers;

use App\Models\Transfers\AssetTransfer;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?AssetTransfer $assetTransfer
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.transfers.form');
    }
}
