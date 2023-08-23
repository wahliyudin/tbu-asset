<?php

namespace App\View\Components\Cers;

use App\DataTransferObjects\Cers\CerItemData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\LaravelData\DataCollection;

class Item extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?CerItemData $cerItem,
        public ?DataCollection $uoms = null,
        public string $type,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cers.item');
    }
}
