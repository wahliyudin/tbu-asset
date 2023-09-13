<?php

namespace App\View\Components\Cers;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Cers\CerData;
use App\Helpers\AuthHelper;
use App\Models\Project;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
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
        public ?Collection $departments = null,
        public string $type = '',
        public bool $isPJO = false,
        public bool $withWorkflow = false,
        public bool $isCurrentWorkflow = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $project = Project::query()
            ->with('departments')
            ->where('pjo', AuthHelper::getNik())
            ->first();
        if ($project) {
            $this->isPJO = true;
            $this->departments = $project->departments;
        }
        return view('components.cers.form');
    }
}
