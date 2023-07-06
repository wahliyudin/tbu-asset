<?php

namespace App\Http\Controllers\API\Cers;

use App\Http\Controllers\Controller;
use App\Services\Cers\CerService;
use App\Traits\APITrait;
use Illuminate\Http\Request;

class CerController extends Controller
{
    use APITrait;

    public function __construct(
        protected CerService $cerService
    ) {
    }

    public function listNoCers(Request $request)
    {
        try {
            return $this->responseSuccess($this->cerService->getListNoCerByUser($request));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($no)
    {
        try {
            return $this->responseSuccess($this->cerService->findByNo($no));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
