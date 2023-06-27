<?php

namespace App\View\Components\Cers;

use App\DataTransferObjects\Cers\CerItemDto;
use App\Models\Cers\CerItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?CerItemDto $cerItem,
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
