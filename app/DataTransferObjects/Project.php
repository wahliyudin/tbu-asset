<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class Project extends Data
{
    public function __construct(
        public ?int $project_id,
        public ?string $project,
        public ?string $project_prefix,
        public ?string $location,
        public ?string $location_prefix,
        public ?int $pjo,
    ) {
    }
}