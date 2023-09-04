<?php

namespace App\Services\SSO;

use App\DataTransferObjects\API\HRIS\UserData;
use App\DataTransferObjects\SSO\TokenDto;
use App\Repositories\SSO\OauthTokenRepository;
use App\Services\API\HRIS\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AuthService
{
    public function __construct(
        protected UserService $userService,
        protected OauthTokenRepository $oauthTokenRepository,
    ) {
    }

    private function urlAuthorize(string $query)
    {
        return config('urls.hris') . "oauth/authorize?$query";
    }

    private function urlCallback()
    {
        return config('urls.hris') . "oauth/token";
    }

    public function authorize(Request $request)
    {
        $request->session()->put("state", $state = Str::random(40));
        $query = http_build_query([
            'client_id' => config('sso.client_id'),
            'redirect_uri' => route('sso.callback'),
            'response_type' => 'code',
            'state' => $state
        ]);
        return redirect($this->urlAuthorize($query));
    }

    public function callback(Request $request)
    {
        $state = $request->session()->pull('state');
        throw_unless(strlen($state) > 0 && $state == $request->state, InvalidArgumentException::class);
        $response = Http::asForm()->post(
            $this->urlCallback(),
            [
                'grant_type' => 'authorization_code',
                'client_id' => config('sso.client_id'),
                'client_secret' => config('sso.client_secret'),
                'redirect_uri' => route('sso.callback'),
                'code' => $request->code
            ]
        );
        $response = $response->json();
        if ($response == null) {
            return to_route('login');
        }
        if (isset($response['error'])) {
            return to_route('login')->with('error', $response['message']);
        }
        $tokenDto = TokenDto::fromJson($response);
        $res = $this->userService->first($tokenDto->access_token);
        $user = $this->userService->storeToUserModel(UserData::from(isset($res['data']) ? $res['data'] : []));
        $this->oauthTokenRepository->store($tokenDto, $user->getKey());
        Auth::login($user);
        return $user;
    }
}
