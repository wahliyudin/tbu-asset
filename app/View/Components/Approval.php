<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\LaravelData\DataCollection;

class Approval extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public DataCollection $workflows
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.approval');
    }
}
