<?php

namespace App\View\Components\Assets;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Collection $projects,
        public Collection $units,
        public Collection $uoms,
        public Collection $subClusters,
        public Collection $employees,
        public $dealers,
        public Collection $leasings,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.assets.form');
    }
}
