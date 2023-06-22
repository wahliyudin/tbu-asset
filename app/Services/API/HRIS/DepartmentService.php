<?php

namespace App\Services\API\HRIS;

use App\Services\API\HRIS\Contracts\HRISService;

class DepartmentService extends HRISService
{
    const PREFIX = '/departments';

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