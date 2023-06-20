<div data-repeater-item class="form-group d-flex align-items-end justify-content-between gap-5">
    <div class="row" style="width: 90%;">
        <input type="hidden" name="key" value="">
        <div class="col-md-4">
            <label for="title" class="form-label">Title
                <small class="text-danger">*</small></label>
            <input type="text" class="form-control form-control-solid" name="title" value="" />
        </div>
        <div class="col-md-4">
            <label class="form-label">Approval
                <small class="text-danger">*</small></label>
            <select class="form-select approval form-select-solid" data-kt-repeater="select2"
                data-placeholder="Approval" name="approval">
                <option selected readonly value="">- Select -</option>
                @foreach (\App\Enums\Settings\Approval::cases() as $approval)
                    <option value="{{ $approval }}">
                        {{ $approval->label() }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 karyawan" style="display: none;">
            <label for="nik" class="form-label">Karyawan
                <small class="text-danger">*</small></label>
            <select class="form-select form-select-solid" data-kt-repeater="select2" data-placeholder="Karyawan"
                id="{{ $settingApproval['module'] }}1" name="nik" data-kode="nik">
                <option selected readonly value="">- Select -</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->nik }}">
                        {{ $employee->nik . ' - ' . $employee->nama_karyawan }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>

    <button type="button" data-repeater-delete class="btn btn-sm btn-icon btn-danger">
        <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1"
                    transform="rotate(-45 7.05025 15.5356)" fill="currentColor" />
                <rect x="8.46447" y="7.05029" width="12" height="2" rx="1"
                    transform="rotate(45 8.46447 7.05029)" fill="currentColor" />
            </svg></span>
    </button>
</div>
