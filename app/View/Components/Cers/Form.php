<?php

namespace App\View\Components\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeDto;
use App\DataTransferObjects\Cers\CerDto;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?CerDto $cer,
        public EmployeeDto $employee,
        public string $type = '',
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
