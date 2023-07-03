<?php

namespace App\View\Components\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferDto;
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
        public ?AssetTransferDto $assetTransfer
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
