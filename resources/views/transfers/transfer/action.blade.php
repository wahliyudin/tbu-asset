<div class="d-flex align-items-center gap-2">
    @if (
        $assetTransfer->_source?->status === \App\Enums\Workflows\Status::CLOSE->value &&
            $assetTransfer->_source?->status_transfer?->status !== \App\Enums\Transfers\Transfer\Status::RECEIVED->value)
        <button type="button" data-transfer="{{ $assetTransfer->_source?->id }}"
            class="btn btn-sm btn-success ps-4 btn-received">
            <span class="indicator-label">
                <div class="d-flex align-items-center gap-2">
                    <i class="ki-duotone ki-check fs-3"></i>Received
                </div>
            </span>
            <span class="indicator-progress">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    @endif
    @if ($assetTransfer->_source?->status === \App\Enums\Workflows\Status::DRAFT->value)
        @permission('asset_transfer_update')
            <a href="{{ route('asset-transfers.edit', $assetTransfer->_source?->id) }}"
                class="btn btn-sm btn-primary ps-4 d-flex"><i class="ki-duotone ki-notepad-edit fs-3">
                    <i class="path1"></i>
                    <i class="path2"></i>
                </i>Edit</a>
        @endpermission
        @permission('asset_transfer_delete')
            <button type="button" data-transfer="{{ $assetTransfer->_source?->id }}"
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
    @endif
    @permission('asset_transfer_read')
        <a href="{{ route('asset-transfers.show', $assetTransfer->_source?->id) }}"
            class="btn btn-sm btn-warning ps-4 d-flex">
            <i class="ki-duotone ki-eye fs-3">
                <i class="path1"></i>
                <i class="path2"></i>
                <i class="path3"></i>
            </i>Detail</a>
    @endpermission
</div>
