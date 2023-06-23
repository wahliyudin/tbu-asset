<?php

namespace App\Models\SSO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token_type',
        'expires_in',
        'access_token',
        'refresh_token',
    ];
}