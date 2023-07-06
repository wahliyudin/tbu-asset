<?php

namespace App\DataTransferObjects\SSO;

use Carbon\Carbon;
use DateTime;

class TokenDto
{
    public function __construct(
        public readonly string $token_type,
        public readonly int $expires_in,
        public readonly string $access_token,
        public readonly string $refresh_token,
    ) {
    }

    public static function fromJson($data): self
    {
        return new self(
            $data['token_type'],
            $data['expires_in'],
            $data['access_token'],
            $data['refresh_token'],
        );
    }

    public function expired(): string
    {
        return Carbon::now()->addSeconds($this->expires_in)->format('Y-m-d H:i:s');
    }
}
