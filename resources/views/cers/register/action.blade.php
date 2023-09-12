<div class="d-flex align-items-center gap-2">
    @permission('asset_master_create')
        <a href="{{ route('asset-registers.create', $cerItem->id) }}" class="btn btn-sm btn-success ps-4 d-flex">
            <i class="ki-duotone ki-add-files fs-3">
                <i class="path1"></i>
                <i class="path2"></i>
                <i class="path3"></i>
            </i>Register</a>
    @endpermission
</div>
