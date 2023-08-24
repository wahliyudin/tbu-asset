<?php

namespace App\Services\API\HRIS;

use App\DataTransferObjects\API\HRIS\UserDto;
use App\Models\User;
use App\Services\API\HRIS\Contracts\HRISService;

class UserService extends HRISService
{
    const PREFIX = '/authuser';

    public function url(): string
    {
        return $this->baseUrl() . self::PREFIX;
    }

    public function first($token)
    {
        return $this->get($this->url(), token: $token)->json();
    }

    public function storeToUserModel(UserDto $dto)
    {
        return User::query()->updateOrCreate([
            'nik' => $dto->nik,
            'email' => $dto->email,
        ], [
            'nik' => $dto->nik,
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);
    }
}
