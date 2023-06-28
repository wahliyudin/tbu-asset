<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Model;

interface ModelWithWorkflowInterface extends Model
{
    public function workflow(): HasOne;

    public function workflows(): HasMany;
}