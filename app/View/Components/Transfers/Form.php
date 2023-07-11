<?php

namespace App\View\Components\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?AssetTransferData $assetTransfer,
        public string $type = '',
        public bool $withWorkflow = false,
        public bool $isCurrentWorkflow = false,
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
