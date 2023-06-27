<?php

namespace App\Services\API\HRIS\Contracts;

use App\Helpers\Helper;
use App\Services\API\APIInterface;
use Illuminate\Support\Facades\Http;

abstract class HRISService implements APIInterface
{
    public function baseUrl()
    {
        $url = config('urls.hris');
        if (in_array(str($url)->substr(strlen($url) - 1), ['/'])) {
            return $url . 'api';
        }
        return $url . '/api';
    }

    public abstract function url();

    public function extendUrl($extend): string
    {
        return $this->url() . "/$extend";
    }

    protected function get($url, $query = null, $token = null)
    {
        $token = $this->token() ?? $token;
        return Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ])->get($url, $query);
    }

    protected function post($url, $data = [], $token = null)
    {
        $token = $this->token() ?? $token;
        return Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ])->post($url, $data);
    }

    private function token()
    {
        return auth()->user()?->oatuhToken?->access_token;
    }
}
