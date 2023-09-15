<div class="d-flex align-items-center gap-2">
    <button type="button" class="btn btn-sm btn-primary ps-4 d-flex align-items-center" data-bs-toggle="modal"
        data-bs-target="#timeline">
        <i class="ki-duotone ki-questionnaire-tablet fs-2">
            <i class="path1"></i>
            <i class="path2"></i>
        </i><span>History</span>
    </button>
    @permission('asset_master_create')
        <a href="{{ route('asset-registers.create', $cerItem->id) }}" @disabled($cerItem->cer?->status_pr === 0)
            class="btn btn-sm btn-success ps-4 d-flex">
            <i class="ki-duotone ki-add-files fs-3">
                <i class="path1"></i>
                <i class="path2"></i>
                <i class="path3"></i>
            </i>Register</a>
    @endpermission
</div>
