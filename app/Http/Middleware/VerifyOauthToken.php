<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Services\API\HRIS\UserService;
use Carbon\Carbon;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyOauthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user instanceof Model) {
                $user->load('oatuhToken');
                if (Carbon::parse($user->oatuhToken?->expires_in) <= now()) {
                    Auth::logout();
                    return redirect(RouteServiceProvider::HOME);
                } else {
                    // $auth = (new UserService)->first($user->oatuhToken?->access_token);
                    // if (!$auth['status']) {
                    //     Auth::logout();
                    //     return redirect(RouteServiceProvider::HOME);
                    // }
                }
            }
        }
        return $next($request);
    }
}