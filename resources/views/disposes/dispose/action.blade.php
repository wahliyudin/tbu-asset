<div class="d-flex align-items-center gap-2">
    @permission('asset_dispose_update')
        <a href="{{ route('asset-disposes.edit', $assetDispose->getKey()) }}" class="btn btn-sm btn-primary ps-4 d-flex"><i
                class="ki-duotone ki-notepad-edit fs-3">
                <i class="path1"></i>
                <i class="path2"></i>
            </i>Edit</a>
    @endpermission
    @permission('asset_dispose_delete')
        <button type="button" data-dispose="{{ $assetDispose->getKey() }}" class="btn btn-sm btn-danger ps-4 btn-delete">
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
</div>
