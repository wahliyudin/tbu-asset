<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

interface ModelWithWorkflowInterface
{
    public function workflow(): HasOne;

    public function workflows(): HasMany;
}
