<div class="d-flex align-items-center gap-2">
    {{-- @permission('access_permission_update') --}}
    <a href="{{ route('settings.access-permission.edit', $employee->nik) }}" class="btn btn-sm btn-primary ps-2">
        <i class="ki-duotone ki-setting-2 fs-2">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>Setting</a>
    {{-- @endpermission --}}
</div>
