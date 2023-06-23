<?php

namespace App\Repositories\SSO;

use App\DataTransferObjects\SSO\TokenDto;
use App\Models\SSO\OauthToken;

class OauthTokenRepository
{
    public function store(TokenDto $dto, $userId)
    {
        return OauthToken::query()->updateOrCreate([
            'user_id' => $userId,
        ], [
            'user_id' => $userId,
            'token_type' => $dto->token_type,
            'expires_in' => $dto->expired(),
            'access_token' => $dto->access_token,
            'refresh_token' => $dto->refresh_token,
        ]);
    }

    public function destroy($userId)
    {
        return OauthToken::query()->where('user_id', $userId)->delete();
    }
}