<?php

namespace App\View\Components\Cers;

use App\DataTransferObjects\Cers\CerDto;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TypeBudget extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?CerDto $cer,
        public string $type,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cers.type-budget');
    }
}
