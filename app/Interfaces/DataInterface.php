<?php

namespace App\Interfaces;

use Spatie\LaravelData\Contracts\DataObject;

interface DataInterface extends DataObject
{
    public function getKey(): string|null;
}
