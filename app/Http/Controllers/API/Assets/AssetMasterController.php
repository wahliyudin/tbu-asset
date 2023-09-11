<?php

namespace App\Http\Controllers\API\Assets;

use App\Http\Controllers\Controller;
use App\Services\Assets\AssetService;
use App\Traits\APITrait;
use Illuminate\Http\Request;

class AssetMasterController extends Controller
{
    use APITrait;

    public function __construct(
        protected AssetService $assetService
    ) {
    }

    public function index()
    {
        try {
            return $this->responseSuccess($this->assetService->allNotElastic());
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
