<?php

namespace App\Services\Workflows\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

interface ModelThatHaveWorkflow
{
    /**
     * @return HasOne
     */
    public function workflow(): HasOne;

    /**
     * @return HasMany
     */
    public function workflows(): HasMany;
}