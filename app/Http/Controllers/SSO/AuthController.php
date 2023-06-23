<?php

namespace App\Http\Controllers\SSO;

use App\Http\Controllers\Controller;
use App\Services\SSO\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function login(Request $request)
    {
        return $this->authService->authorize($request);
    }

    public function callback(Request $request)
    {
        try {
            $this->authService->callback($request);
            return to_route('home');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}