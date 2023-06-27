<?php

namespace App\View\Components\Disposes;

use App\DataTransferObjects\API\HRIS\EmployeeDto;
use App\DataTransferObjects\Disposes\AssetDisposeDto;
use App\Models\Disposes\AssetDispose;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?AssetDisposeDto $assetDispose,
        public EmployeeDto $employee,
        public string $type = '',
        public bool $isCurrentWorkflow = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.disposes.form');
    }
}
