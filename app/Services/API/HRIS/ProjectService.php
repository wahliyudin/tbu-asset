<?php

namespace App\Services\API\HRIS;

use App\Services\API\HRIS\Contracts\HRISService;

class ProjectService extends HRISService
{
    const PREFIX = '/projects';

    public function url(): string
    {
        return $this->baseUrl() . self::PREFIX;
    }

    public function all()
    {
        return $this->get($this->url())->json();
    }

    public function getById($id)
    {
        return $this->get($this->extendUrl($id))->json();
    }
}