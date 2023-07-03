<?php

namespace App\DataTransferObjects\API\HRIS;

class UserDto
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $nik,
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?string $password,
    ) {
    }

    public static function fromResponse(array $response): self
    {
        $data = [];
        if (isset($response['data'])) {
            $data = $response['data'];
        }
        return new self(
            isset($data['id']) ? $data['id'] : null,
            isset($data['nik']) ? $data['nik'] : null,
            isset($data['name']) ? $data['name'] : null,
            isset($data['email']) ? $data['email'] : null,
            isset($data['password']) ? $data['password'] : null,
        );
    }
}