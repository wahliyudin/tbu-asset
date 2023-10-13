<div class="d-flex align-items-center gap-2">
    @permission('asset_transfer_create')
        <a href="{{ route('asset-transfers.create', ['asset' => $kode]) }}" class="btn btn-sm btn-primary ps-4">
            <i class="ki-duotone ki-share fs-2">
                <i class="path1"></i>
                <i class="path2"></i>
                <i class="path3"></i>
                <i class="path4"></i>
                <i class="path5"></i>
                <i class="path6"></i>
            </i>Transfer
        </a>
    @endpermission
</div>
