<?php

namespace App\Http\Controllers\API\Cers;

use App\Http\Controllers\Controller;
use App\Services\Cers\CerItemService;
use App\Traits\APITrait;
use Illuminate\Http\Request;

class CerItemController extends Controller
{
    use APITrait;

    public function __construct(
        protected CerItemService $cerItemService,
    ) {
    }

    public function listIds()
    {
        try {
            return $this->responseSuccess($this->cerItemService->all()?->pluck('id'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
