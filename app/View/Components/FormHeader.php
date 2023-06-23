<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $title,
        public $nomor,
        public $tanggal,
        public $revisi,
        public $halaman,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-header');
    }
}