<?php

namespace App\Http\Controllers\Settings;

use App\DataTransferObjects\Settings\ApprovalDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ApprovalRequest;
use App\Repositories\Settings\ApprovalRepository;

class SettingApprovalController extends Controller
{
    public function __construct(
        protected ApprovalRepository $approvalRepository
    ) {
    }

    public function index()
    {
        return view('settings.approval.index', [
            'employees' => [], // get API employees
            'settingApprovals' => ApprovalRepository::dataForView()
        ]);
    }

    public function store(ApprovalRequest $request)
    {
        try {
            $this->approvalRepository->updateOrCreate(ApprovalDto::fromRequest($request));
            return response()->json([
                'message' => 'Successfully'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
