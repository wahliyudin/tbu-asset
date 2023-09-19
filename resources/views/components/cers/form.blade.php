<form action="" class="form-cer">
    <input type="hidden" name="id" value="{{ $cer?->id }}">
    <x-form-header title="CAPITAL EXPENDITURE REQUEST" nomor="TBU-FM-AST-001" tanggal="12-04-2023" revisi="00"
        halaman="1 dari 1" />
    <hr>
    <div class="row">
        <div class="col-md-6">
            <x-cers.peruntukan :cer="$cer" :type="$type" />
        </div>
        <div class="col-md-6">
            <x-cers.type-budget :cer="$cer" :type="$type" />
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <table class="w-100">
                <tbody>
                    <tr>
                        <td class="fs-6 fw-semibold w-150px">Department</td>
                        <td>:</td>
                        <td class="department">
                            <input type="hidden" name="deptcode"
                                value="{{ $employee?->position?->department?->budget_dept_code }}">
                            @if ($isPJO)
                                <select class="form-select form-select" @disabled($type == 'show')
                                    name="department_id" data-control="select2" data-placeholder="Department"
                                    data-dropdown-parent=".department">
                                    <option selected disabled value="">- pilih -</option>
                                    @foreach ($departments as $department)
                                        <option @selected($cer?->department_id == $department->dept_id) value="{{ $department->dept_id }}">
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="hidden" name="department_id"
                                    value="{{ $employee?->position?->department?->dept_id }}">
                                {{ $employee?->position?->department?->department_name }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fs-6 fw-semibold w-150px">Project</td>
                        <td>:</td>
                        <td>
                            {{ $employee?->position?->project?->project }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fs-6 fw-semibold w-150px">Lokasi</td>
                        <td>:</td>
                        <td>
                            {{ $employee?->position?->project?->location }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="w-100">
                <tbody>
                    <tr>
                        <td class="fs-6 fw-semibold">Tanggal Pengajuan</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="tanggal_pengajuan" disabled
                                value="{{ isset($cer?->created_at) ? $cer?->created_at : now()->format('Y-m-d') }}"
                                class="form-control date">
                        </td>
                    </tr>
                    <tr>
                        <td class="fs-6 fw-semibold">Tanggal Kebutuhan</td>
                        <td>:</td>
                        <td>
                            <input type="text" @readonly(isset($cer?->tgl_kebutuhan))
                                value="{{ isset($cer?->tgl_kebutuhan) ? $cer?->tgl_kebutuhan : '' }}"
                                name="tgl_kebutuhan" class="form-control date">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex flex-column mt-4 me-4">
        <div class="d-flex flex-column">
            <h5>1. Justifikasi / alasan pengadaan</h5>
            <textarea name="justifikasi" @readonly($type == 'show') class="form-control ms-4">{{ isset($cer?->justifikasi) ? $cer?->justifikasi : '' }}</textarea>
        </div>
        <div class="d-flex flex-column mt-4">
            <h5>2. Items</h5>
            <div class="d-flex justify-content-end py-2">
                @if ($type != 'show')
                    <button type="button" class="btn btn-sm btn-primary ps-3 add-item"><i
                            class="ki-duotone ki-plus fs-3"></i>Tambah</button>
                @endif
            </div>
            <div class="table-responsive ms-4" style="margin-right: -10px;">
                <table class="table table-bordered border-gray-300 items">
                    <thead>
                        <tr class="fw-bold text-center bg-secondary bg-opacity-50">
                            <th class="fs-6 fw-semibold w-200px">Asset Description</th>
                            <th class="fs-6 fw-semibold w-200px">Asset Model</th>
                            <th class="fs-6 fw-semibold w-200px">Est. Umur Asset</th>
                            <th class="fs-6 fw-semibold w-150px">Uom</th>
                            <th class="fs-6 fw-semibold w-100px">Asset Qty</th>
                            <th class="fs-6 fw-semibold w-200px">Unit Price</th>
                            <th class="fs-6 fw-semibold w-200px">Sub Total Price</th>
                            @if ($type != 'show')
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody data-repeater-list="items">
                        @php
                            $subTotal = 0;
                        @endphp
                        @forelse ($cer?->items ?? [] as $item)
                            @php
                                $subTotal += $item->qty * $item->price;
                            @endphp
                            <x-cers.item :cerItem="$item" :uoms="$uoms" :type="$type" />
                        @empty
                            <x-cers.item :type="$type" :uoms="$uoms" />
                        @endforelse
                    </tbody>
                    <tfoot style="display: none;">
                        <tr>
                            <td colspan="6"></td>
                            <td>
                                <button type="button" data-repeater-create class="btn btn-sm btn-info ps-3 pe-2">
                                    <i class="ki-duotone ki-plus fs-3"></i>
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-8">
                <h5>3. Harga Total (estimasi)</h5>
            </div>
            <div class="col-md-4 pe-0 ps-8">
                <table class="table table-bordered border-gray-300 w-100">
                    <tbody>
                        <tr>
                            <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50"
                                style="vertical-align: middle;">IDR</td>
                            <td class="w-200px">
                                <input type="text" readonly name="total_idr"
                                    value="{{ \App\Helpers\Helper::formatRupiah($subTotal) }}"
                                    class="form-control uang">
                            </td>
                        </tr>
                        <tr>
                            <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50"
                                style="vertical-align: middle;">USD</td>
                            <td class="w-200px">
                                <input type="text" readonly name="total_usd" class="form-control uang">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <h5>4. Sumber Pendanaan</h5>
            </div>
            <div class="col-md-8">
                <x-cers.sumber-pendanaan :cer="$cer" :type="$type" />
            </div>
        </div>
        <input type="hidden" name="budget_ref" value="{{ $cer?->budget_ref }}">
        <div class="row mt-4 budget">
            <div class="col-md-4 d-flex justify-content-between align-items-start">
                <h5>5. Budget</h5>
                @if ($type != 'show')
                    <button type="button" @disabled(\App\Helpers\Helper::hasUnBudgeted($cer))
                        class="btn btn-sm btn-primary ps-3 pe-2 search-budget">
                        <i class="ki-duotone ki-search-list fs-2">
                            <i class="path1"></i>
                            <i class="path2"></i>
                            <i class="path3"></i>
                        </i>
                    </button>
                @endif
            </div>
            <div class="col-md-4">
                <table class="table table-bordered w-100 border-gray-300">
                    <tbody>
                        <tr>
                            <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">Ref No</td>
                            <td class="w-250px">
                                <input type="text" class="form-control" readonly
                                    value="{{ \App\Helpers\Helper::hasBudgeted($cer) ? $cer?->budget_ref : null }}"
                                    name="view_budget_ref">
                            </td>
                        </tr>
                        <tr>
                            <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">Periode (tahun)
                            </td>
                            <td class="w-250px">
                                <input type="text" class="form-control" readonly
                                    value="{{ \App\Helpers\Helper::hasBudgeted($cer) ? $cer?->budget?->periode : null }}"
                                    name="budget_periode">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 pe-0">
                <table class="table table-bordered w-100 border-gray-300">
                    <tbody>
                        <tr>
                            <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">IDR</td>
                            <td class="w-250px">
                                <input type="text" class="form-control" readonly
                                    value="{{ \App\Helpers\Helper::hasBudgeted($cer) ? \App\Helpers\Helper::formatRupiah($cer?->budget?->total) : null }}"
                                    name="total_budget_idr">
                            </td>
                        </tr>
                        <tr>
                            <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">USD
                            </td>
                            <td class="w-250px">
                                <input type="text" class="form-control" readonly name="total_budget_usd">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row justify-content-end mt-4 unbudget d-none">
            <div class="col-md-4 d-flex justify-content-between align-items-start">
                <h5>5. Unbudget</h5>
                @if ($type != 'show')
                    <button type="button" @disabled(\App\Helpers\Helper::hasBudgeted($cer))
                        class="btn btn-sm btn-primary ps-3 pe-2 search-budget">
                        <i class="ki-duotone ki-search-list fs-2">
                            <i class="path1"></i>
                            <i class="path2"></i>
                            <i class="path3"></i>
                        </i>
                    </button>
                @endif
            </div>
            <div class="col-md-4">
                <table class="table table-bordered w-100 border-gray-300">
                    <tbody>
                        <tr>
                            <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">Ref No</td>
                            <td class="w-250px">
                                <input type="text" class="form-control unbudget_ref" readonly
                                    value="{{ \App\Helpers\Helper::hasUnBudgeted($cer) ? $cer?->budget_ref : null }}"
                                    name="view_budget_ref">
                            </td>
                        </tr>
                        <tr>
                            <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">Periode (tahun)
                            </td>
                            <td class="w-250px">
                                <input type="text" class="form-control unbudget_periode" readonly
                                    value="{{ \App\Helpers\Helper::hasUnBudgeted($cer) ? $cer?->budget?->periode : null }}"
                                    name="budget_periode">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 pe-0">
                <table class="table table-bordered w-100 border-gray-300">
                    <tbody>
                        <tr>
                            <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">IDR</td>
                            <td class="w-250px">
                                <input type="text" class="form-control total_unbudget_idr" readonly
                                    value="{{ \App\Helpers\Helper::hasUnBudgeted($cer) ? \App\Helpers\Helper::formatRupiah($cer?->budget?->total) : null }}"
                                    name="total_budget_idr">
                            </td>
                        </tr>
                        <tr>
                            <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">USD
                            </td>
                            <td class="w-250px">
                                <input type="text" class="form-control" readonly name="total_budget_usd">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-8">
                <input type="file" class="form-control" readonly name="file_ucr" placeholder="File UCR">
            </div>
        </div>
        <div class="d-flex flex-column mt-4">
            <h5>7. Cost & Benefit Analyst</h5>
            <textarea name="cost_analyst" @readonly($type == 'show') class="form-control ms-4">{{ isset($cer?->cost_analyst) ? $cer?->cost_analyst : '' }}</textarea>
        </div>
    </div>
    @if ($type != 'show')
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary simpan-form-cer">
                <span class="indicator-label">
                    Simpan
                </span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    @endif
</form>
@if ($type == 'show' && $withWorkflow)
    <div class="row mt-8">
        <x-approval :workflows="$cer?->workflows" />
        <div class="col-md-12 d-flex justify-content-start mt-4">
            @permission('asset_request_approv')
                <button type="button" data-cer="{{ $cer?->id }}"
                    class="btn btn-success ps-4 approv {{ !$isCurrentWorkflow ? 'd-none' : '' }}">
                    <span class="indicator-label">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ki-duotone ki-check-circle fs-2">
                                <i class="path1"></i>
                                <i class="path2"></i>
                            </i>Approval
                        </div>
                    </span>
                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            @endpermission
            @permission('asset_request_reject')
                <button type="button" data-cer="{{ $cer?->id }}"
                    class="btn btn-danger ms-2 ps-4 reject  {{ !$isCurrentWorkflow ? 'd-none' : '' }}">
                    <span class="indicator-label">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ki-duotone ki-cross-circle fs-2">
                                <i class="path1"></i>
                                <i class="path2"></i>
                            </i>Reject
                        </div>
                    </span>
                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            @endpermission
        </div>
    </div>
@endif
@if ($type != 'show')
    @push('js')
        <script>
            $(document).ready(function() {
                $('input[name="type_budget"]').change(function(e) {
                    e.preventDefault();
                    if ($(this).val() == '{{ \App\Enums\Cers\TypeBudget::BUDGET }}') {
                        $('.unbudget').addClass('d-none');
                        $('.budget').removeClass('d-none');
                    } else {
                        $('.budget').addClass('d-none');
                        $('.unbudget').removeClass('d-none');
                    }
                });

            });
        </script>
    @endpush
@endif
@if ($type == 'show')
    @push('js')
        <script src="{{ asset('assets/js/pages/cer/form.js') }}"></script>
    @endpush
@endif
