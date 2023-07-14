<div class="d-flex align-items-center gap-2">
    @permission('asset_master_update')
        <button type="button" data-asset="{{ $asset->_source->id ?? $asset->_source->key }}"
            class="btn btn-sm btn-primary ps-4 btn-edit">
            <span class="indicator-label">
                <div class="d-flex align-items-center gap-2">
                    <i class="ki-duotone ki-notepad-edit fs-3">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>Edit
                </div>
            </span>
            <span class="indicator-progress">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    @endpermission
    @permission('asset_master_delete')
        <button type="button" data-asset="{{ $asset->_source->id ?? $asset->_source->key }}"
            class="btn btn-sm btn-danger ps-4 btn-delete">
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
