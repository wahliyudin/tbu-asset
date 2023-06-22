<?php

namespace App\Services\API\HRIS\Contracts;

use App\Helpers\Helper;
use App\Services\API\APIInterface;
use Illuminate\Support\Facades\Http;

abstract class HRISService implements APIInterface
{
    public function baseUrl()
    {
        return Helper::clearUrl(config('urls.hris') . '/api');
    }

    public abstract function url();

    public function extendUrl($extend): string
    {
        return $this->url() . "/$extend";
    }

    protected function get($url, $query = null)
    {
        return Http::withHeaders([
            'Accept' => 'application/json'
        ])->get($url, $query);
    }
}