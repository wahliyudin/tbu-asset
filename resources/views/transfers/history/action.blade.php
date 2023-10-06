<div class="d-flex align-items-center gap-2">
    {{-- <a href="{{ route('asset-transfers.histories.detail', $asset->getKey()) }}"
        class="btn btn-sm btn-warning ps-4 d-flex">
        <i class="ki-duotone ki-eye fs-3">
            <i class="path1"></i>
            <i class="path2"></i>
            <i class="path3"></i>
        </i>Detail</a> --}}
    <button type="button" data-asset="{{ $asset->getKey() }}" class="btn btn-sm btn-info ps-4 btn-show">
        <span class="indicator-label">
            <div class="d-flex align-items-center gap-2">
                <i class="ki-duotone ki-questionnaire-tablet fs-2">
                    <i class="path1"></i>
                    <i class="path2"></i>
                </i>History
            </div>
        </span>
        <span class="indicator-progress">
            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
    </button>
</div>
