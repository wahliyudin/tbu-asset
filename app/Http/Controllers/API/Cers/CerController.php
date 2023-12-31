<?php

namespace App\Http\Controllers\API\Cers;

use App\Http\Controllers\Controller;
use App\Models\Cers\Cer;
use App\Services\Cers\CerService;
use App\Traits\APITrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function updateStatusPr($noCer, Request $request)
    {
        try {
            // $validator = Validator::make($request->all(), [
            //     'status_pr' => 'required'
            // ]);
            // if ($validator->fails()) {
            //     return $this->response($validator->messages(), false, '', 422);
            // }
            $cer = Cer::query()->with(['items', 'workflows'])->where('no_cer', $noCer)->first();
            if (!$cer) {
                return $this->response([], false, 'Not Found', 404);
            }
            $this->cerService->update($cer, [
                'status_pr' => true
            ]);
            return $this->responseSuccess([
                'message' => 'Berhasil di ubah'
            ]);
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
