<?php

namespace App\Services\API;

interface APIInterface
{
    public function baseUrl();

    public function url();

    public function extendUrl($extend): string;
}