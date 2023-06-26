<form action="" class="form-cer">
    <x-form-header title="CAPITAL EXPENDITURE REQUEST" nomor="TBU-FM-AST-001" tanggal="12-04-2023" revisi="00"
        halaman="1 dari 1" />
    <hr>
    <div class="row">
        <div class="col-md-6">
            <x-cers.peruntukan :cer="$cer" />
        </div>
        <div class="col-md-6">
            <x-cers.type-budget :cer="$cer" />
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <table class="w-100">
                <tbody>
                    <tr>
                        <td class="fs-6 fw-semibold w-150px">Department</td>
                        <td>:</td>
                        <td>
                            {{ $employee->position->department->department_name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fs-6 fw-semibold w-150px">Project</td>
                        <td>:</td>
                        <td>
                            {{ $employee->position->project->project }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fs-6 fw-semibold w-150px">Lokasi</td>
                        <td>:</td>
                        <td>
                            {{ $employee->position->project->location }}
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
                                value="{{ isset($cer->created_at) ? $cer->created_at : now()->format('Y-m-d') }}"
                                class="form-control date">
                        </td>
                    </tr>
                    <tr>
                        <td class="fs-6 fw-semibold">Tanggal Kebutuhan</td>
                        <td>:</td>
                        <td>
                            <input type="text" @readonly(isset($cer->tgl_kebutuhan))
                                value="{{ isset($cer->tgl_kebutuhan) ? $cer->tgl_kebutuhan : '' }}" name="tgl_kebutuhan"
                                class="form-control date">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex flex-column mt-4 me-4">
        <div class="d-flex flex-column">
            <h5>1. Justifikasi / alasan pengadaan</h5>
            <textarea name="justifikasi" @readonly($cer->justifikasi) class="form-control ms-4">{{ isset($cer->justifikasi) ? $cer->justifikasi : '' }}</textarea>
        </div>
        <div class="d-flex flex-column mt-4">
            <h5>2. Items</h5>
            <div class="d-flex justify-content-end py-2">
                @if (count($cer->items) <= 0)
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
                            <th class="fs-6 fw-semibold w-100px">Asset Qty</th>
                            <th class="fs-6 fw-semibold w-200px">Unit Price</th>
                            <th class="fs-6 fw-semibold w-200px">Sub Total Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody data-repeater-list="items">
                        <tr data-repeater-item>
                            <td>
                                <input type="hidden" name="asset" class="asset">
                                <input type="text" readonly name="description"
                                    class="form-control asset-description">
                            </td>
                            <td>
                                <input type="text" readonly name="model" class="form-control asset-model">
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="number" name="est_umur" min="1"
                                        class="form-control umur-asset">
                                    <span class="input-group-text">Bulan</span>
                                </div>
                            </td>
                            <td>
                                <input type="number" name="qty" min="1" value="1"
                                    class="form-control qty">
                            </td>
                            <td>
                                <input type="text" name="price" readonly class="form-control uang price">
                            </td>
                            <td>
                                <input type="text" readonly class="form-control uang sub-total">
                            </td>
                            <td>
                                <button type="button" data-repeater-delete class="btn btn-sm btn-danger ps-3 pe-2">
                                    <i class="ki-duotone ki-trash fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </button>
                            </td>
                        </tr>
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
                                <input type="text" readonly name="total_idr" class="form-control uang">
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
                <x-cers.sumber-pendanaan />
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4 d-flex justify-content-between align-items-start">
                <h5>5. Badget</h5>
                <button type="button" class="btn btn-sm btn-primary ps-3 pe-2 search-budget">
                    <i class="ki-duotone ki-search-list fs-2">
                        <i class="path1"></i>
                        <i class="path2"></i>
                        <i class="path3"></i>
                    </i>
                </button>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered w-100 border-gray-300">
                    <tbody>
                        <tr>
                            <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">Ref No</td>
                            <td class="w-250px">
                                <input type="text" class="form-control" readonly name="budget_ref">
                            </td>
                        </tr>
                        <tr>
                            <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">Periode (tahun)
                            </td>
                            <td class="w-250px">
                                <input type="text" class="form-control" readonly name="budget_periode">
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
                                <input type="text" class="form-control" readonly name="total_budget_idr">
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
        <div class="d-flex flex-column mt-4">
            <h5>6. Cost & Benefit Analyst</h5>
            <textarea name="cost_analyst" @readonly(isset($cer->cost_analyst)) class="form-control ms-4">{{ isset($cer->cost_analyst) ? $cer->cost_analyst : '' }}</textarea>
        </div>
    </div>
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
</form>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-center">
            @foreach ($cer->workflows as $workflow)
                <div class="d-flex flex-column w-200px {{ $workflow->last_action == \App\Enums\Workflows\LastAction::APPROV ? 'bg-success' : ($workflow->last_action == \App\Enums\Workflows\LastAction::REJECT ? 'bg-danger' : 'bg-warning') }}"
                    style="border-radius: {{ $workflow->sequence == 1 ? '10px 0 0 10px' : ($workflow->sequence == count($cer->workflows) ? '0 10px 10px 0' : '0 0 0 0') }}; overflow: hidden;">
                    <div class="border text-center text-white p-1 d-flex flex-column">
                        <p class="m-0 fw-bold" style="font-size: 15px;">
                            {{ $workflow->title }}
                            By
                        </p>
                        <p class="m-0">{{ $workflow?->employee?->nama_karyawan }}</p>
                    </div>
                    <div class="border text-center text-white p-1 d-flex flex-column">
                        <p class="m-0 fw-bold" style="font-size: 15px;">
                            {{ $workflow->title }}
                            On
                        </p>
                        <p class="m-0">
                            {{ $workflow->last_action == \App\Enums\Workflows\LastAction::APPROV ? $workflow?->last_action_date : '-' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- <div class="col-md-12 d-flex justify-content-start mt-4">
        @permission('cer_approv')
            <button {{ !$isCurrentWorkflow ? 'disabled' : '' }} data-cer="{{ $cer->getKey() }}"
                class="btn btn-success text-white approv">Approval</button>
        @endpermission
        @permission('cer_reject')
            <button {{ !$isCurrentWorkflow ? 'disabled' : '' }} data-cer="{{ $cer->getKey() }}"
                class="btn btn-danger text-white ms-2 reject">Reject</button>
        @endpermission
    </div> --}}
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('input[name="type_budget"]').change(function(e) {
                e.preventDefault();
                if ($(this).val() == '{{ \App\Enums\Cers\TypeBudget::BUDGET }}') {
                    $('.search-budget').attr('disabled', false);
                } else {
                    $('.search-budget').attr('disabled', true);
                    $('input[name="budget_ref"]').val('');
                    $('input[name="budget_periode"]').val('');
                    $('input[name="total_budget_idr"]').val('');
                }
            });
        });
    </script>
@endpush
