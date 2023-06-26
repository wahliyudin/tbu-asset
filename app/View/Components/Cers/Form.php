<?php

namespace App\View\Components\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeDto;
use App\Models\Cers\Cer;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?Cer $cer,
        public EmployeeDto $employee,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cers.form');
    }
}
