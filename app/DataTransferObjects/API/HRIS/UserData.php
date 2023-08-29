<?php

namespace App\DataTransferObjects\API\HRIS;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public ?int $id,
        public ?int $nik,
        public ?string $name,
        public ?string $email,
        public ?string $password,
        public ?EmployeeData $employee,
    ) {
    }
}
