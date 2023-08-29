<?php

namespace App\Services\API\HRIS;

use App\DataTransferObjects\API\HRIS\UserData;
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

    public function storeToUserModel(UserData $data)
    {
        return User::query()->updateOrCreate([
            'nik' => $data->nik,
            'email' => $data->email,
        ], [
            'nik' => $data->nik,
            'name' => $data->employee?->nama_karyawan,
            'email' => $data->email,
            'password' => $data->password,
        ]);
    }
}
