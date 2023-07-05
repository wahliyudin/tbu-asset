<?php

namespace App\View\Components\Cers;

use App\DataTransferObjects\Cers\CerData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Peruntukan extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?CerData $cer,
        public string $type,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cers.peruntukan');
    }
}