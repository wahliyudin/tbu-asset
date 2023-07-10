<div class="d-flex align-items-center gap-2">
    @permission('asset_request_update')
        <a href="{{ route('asset-requests.edit', $cer->getKey()) }}" class="btn btn-sm btn-primary ps-4 d-flex"><i
                class="ki-duotone ki-notepad-edit fs-3">
                <i class="path1"></i>
                <i class="path2"></i>
            </i>Edit</a>
    @endpermission
    @permission('asset_request_delete')
        <button type="button" data-cer="{{ $cer->getKey() }}" class="btn btn-sm btn-danger ps-4 btn-delete">
            <span class="indicator-label">
                <div class="d-flex align-items-center gap-2">
                    <i class="ki-duotone ki-trash fs-3">
                        <i class="path1"></i>
                        <i class="path2"></i>
                        <i class="path3"></i>
                        <i class="path4"></i>
                        <i class="path5"></i>
                    </i>Delete
                </div>
            </span>
            <span class="indicator-progress">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    @endpermission
    @if ($cer->status == \App\Enums\Workflows\Status::CLOSE)
        <a href="{{ route('asset-requests.register', $cer->getKey()) }}" class="btn btn-sm btn-success ps-4 d-flex">
            <i class="ki-duotone ki-add-files fs-3">
                <i class="path1"></i>
                <i class="path2"></i>
                <i class="path3"></i>
            </i>Register</a>
    @endif
</div>
