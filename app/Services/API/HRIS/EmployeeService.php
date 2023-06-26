<?php

namespace App\Services\API\HRIS;

use App\Services\API\HRIS\Contracts\HRISService;

class EmployeeService extends HRISService
{
    const PREFIX = '/employees';

    private $query = [];

    public function url(): string
    {
        return $this->baseUrl() . self::PREFIX;
    }

    public function all()
    {
        return $this->get($this->url())->json();
    }

    public function whereIn($field, array $values)
    {
        $this->query = array_merge($this->query, [str($field)->plural()->value() => $values]);
        return $this;
    }

    public function first()
    {
        $response = $this->getData();
        $data = [];
        if (isset($response['data'])) {
            $data = count($response['data']) > 0 ? $response['data'][0] : $response['data'];
            $response['data'] = $data;
        }
        return $response;
    }

    public function getData()
    {
        return $this->get($this->url(), $this->query)->json();
    }

    public function getByNik($nik)
    {
        return $this->get($this->extendUrl($nik), $this->query)->json();
    }
}
