<?php

namespace App\Repositories\API\HRIS;

use App\Services\API\HRIS\Contracts\HRISService;

class ApprovalRepository extends HRISService
{
    const PREFIX = '/workflows';

    public function url(): string
    {
        return $this->baseUrl() . self::PREFIX;
    }

    public function getBySubmitted(array $data)
    {
        return $this->post($this->url(), $data)->json();
    }
}
