<?php

namespace App\Services\API\HRIS;

use App\Services\API\HRIS\Contracts\HRISService;

class EmployeeService extends HRISService
{
    const PREFIX = '/employees';

    public function url(): string
    {
        return $this->baseUrl() . self::PREFIX;
    }

    public function all()
    {
        return $this->get($this->url())->json();
    }

    public function getByNik($nik)
    {
        return $this->get($this->extendUrl($nik))->json();
    }
}