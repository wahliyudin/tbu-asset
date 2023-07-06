<?php

namespace App\View\Components\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Cers\CerData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\LaravelData\DataCollection;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?CerData $cer,
        public EmployeeData $employee,
        public ?DataCollection $uoms = null,
        public string $type = '',
        public bool $isCurrentWorkflow = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cers.form');
    }
}
