<form action="" class="form-transfer">
    <input type="hidden" name="id" value="{{ $assetTransfer->id }}">
    <input type="hidden" name="no_transaksi" value="{{ $assetTransfer->no_transaksi }}">
    <input type="hidden" name="nik" value="{{ $assetTransfer->nik }}">
    <input type="hidden" name="asset_id" value="{{ $assetTransfer->asset_id }}">
    <x-form-header title="TRANSFER ASSET" nomor="TBU-FM-AST-003" tanggal="12-04-2023" revisi="00"
        halaman="1 dari 1" />
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if ($type != 'show')
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-sm btn-primary ps-3 btn-select-asset">
                        <i class="ki-duotone ki-search-list fs-2">
                            <i class="path1"></i>
                            <i class="path2"></i>
                            <i class="path3"></i>
                        </i>Pilih Asset</button>
                </div>
            @endif
            <h5>Dengan ini mengajukan permintaan pemindahan (transfer) asset dengan data berikut: (*)</h5>
            <table class="w-100 ms-8 mt-4">
                <tbody>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Nama Asset</td>
                        <td style="width: 10px;">:</td>
                        <td id="nama">{{ $assetTransfer->asset?->kode }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Merk/Tipe/Model</td>
                        <td style="width: 10px;">:</td>
                        <td id="merk_tipe_model">{{ $assetTransfer->asset?->asset_unit?->brand }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Serial Number Asset</td>
                        <td style="width: 10px;">:</td>
                        <td id="serial_number">{{ $assetTransfer->asset?->asset_unit?->serial_number }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Nomor Asset</td>
                        <td style="width: 10px;">:</td>
                        <td id="nomor_asset">{{ $assetTransfer->asset?->kode }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Nilai Akuisisi / Nilai Buku
                        </td>
                        <td style="width: 10px;">:</td>
                        <td id="niali_buku">
                            {{ \App\Helpers\Helper::formatRupiah($assetTransfer->asset?->leasing?->harga_beli, true) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Kelengkapan Asset</td>
                        <td style="width: 10px;">:</td>
                        <td id="kelengkapan">{{ $assetTransfer->asset?->asset_unit?->spesification }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-8">
        <div class="col-md-12 ps-12">
            <input type="hidden" name="old_pic" value="{{ $assetTransfer->oldPic?->nik }}">
            <input type="hidden" name="new_pic" value="{{ $assetTransfer->newPic?->nik }}">
            <table class="table table-bordered border-gray-300">
                <thead class="border-0">
                    <tr class="text-center border-0">
                        <th class="border-0"></th>
                        <th class="border border-gray-300 bg-secondary bg-opacity-50">User Lama</th>
                        <th class="border border-gray-300 bg-secondary bg-opacity-50">User Baru</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="bg-secondary bg-opacity-50 w-200px">Nama Pemegang Asset</th>
                        <td class="w-450px">
                            <input type="text" class="form-control" readonly name="old_nama_karyawan"
                                value="{{ $assetTransfer->oldPic?->nama_karyawan ?? '-' }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" readonly name="new_nama_karyawan"
                                value="{{ $assetTransfer->newPic?->nama_karyawan ?? '-' }}">
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-secondary bg-opacity-50 w-200px">Department</th>
                        <td class="w-450px">
                            <input type="text" class="form-control" readonly name="old_department"
                                value="{{ $assetTransfer->oldPic?->position?->department?->department_name ?? '-' }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" readonly name="new_department"
                                value="{{ $assetTransfer->newPic?->position?->department?->department_name ?? '-' }}">
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-secondary bg-opacity-50 w-200px">Division</th>
                        <td class="w-450px">
                            <input type="text" class="form-control" readonly name="old_divisi"
                                value="{{ $assetTransfer->oldPic?->position?->divisi?->division_name ?? '-' }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" readonly name="new_divisi"
                                value="{{ $assetTransfer->newPic?->position?->divisi?->division_name ?? '-' }}">
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-secondary bg-opacity-50 w-200px">Project</th>
                        <td class="w-450px">
                            <input type="text" class="form-control" readonly name="old_project"
                                value="{{ $assetTransfer->oldPic?->position?->project?->project ?? '-' }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" readonly name="new_project"
                                value="{{ $assetTransfer->newPic?->position?->project?->project ?? '-' }}">
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-secondary bg-opacity-50 w-200px">Lokasi</th>
                        <td class="w-450px">
                            <input type="text" class="form-control" readonly name="old_location"
                                value="{{ $assetTransfer->oldPic?->position?->project?->location ?? '-' }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" readonly name="new_location"
                                value="{{ $assetTransfer->newPic?->position?->project?->location ?? '-' }}">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-4 align-items-end ps-8">
        <div class="col-md-5">
            <h5>Tanggal Permintaan Pemindahan (Transfer)</h5>
        </div>
        <div class="col-md-5">
            <table class="table table-bordered border-gray-400 m-0">
                <thead class="border-0">
                    <tr class="text-center border-0">
                        <th colspan="2" class="border-0">Tgl.</th>
                        <th colspan="4" class="border-0">Bln</th>
                        <th colspan="4" class="border-0">Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        @foreach (str(\Carbon\Carbon::make($assetTransfer?->created_at ?? now()->format('d-m-Y'))->format('d-m-Y'))->split(1) as $value)
                            <td class="p-1" style="width: 10px !important;">{{ $value }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-4">
        <h5>Justifikasi/ Alasan Pemindahan (Transfer) Asset, yaitu :</h5>
        <div class="ps-10">
            @if ($type == 'show')
                <div class="w-100 fs-5">{!! $assetTransfer->justifikasi !!}</div>
            @else
                <div id="justifikasi" class="w-100">{!! $assetTransfer->justifikasi !!}</div>
            @endif
        </div>
    </div>
    @if ($type == 'show' && $withWorkflow)
        <div class="row mt-8">
            <x-approval :workflows="$assetTransfer->workflows" />
            <div class="col-md-12 d-flex justify-content-start mt-4">
                @permission('asset_transfer_approv')
                    <button type="button" data-transfer="{{ $assetTransfer->id }}"
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
                @permission('asset_transfer_reject')
                    <button type="button" data-transfer="{{ $assetTransfer->id }}"
                        class="btn btn-danger ms-2 ps-4 reject {{ !$isCurrentWorkflow ? 'd-none' : '' }}">
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
        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-warning simpan-draft-form-transfer ps-4">
                <span class="indicator-label">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ki-duotone ki-archive-tick fs-2">
                            <i class="path1"></i>
                            <i class="path2"></i>
                        </i>
                        <span>Simpan Draft</span>
                    </div>
                </span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
            <button type="button" class="btn btn-primary simpan-form-transfer ps-4">
                <span class="indicator-label">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ki-duotone ki-save-2 fs-2">
                            <i class="path1"></i>
                            <i class="path2"></i>
                        </i>
                        <span>Submit</span>
                    </div>
                </span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    @endif
</form>
@if ($type != 'show')
    @push('modal')
        @include('transfers.transfer.modals.data-asset')
    @endpush
    @push('css')
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
            type="text/css" />
        <style>
            ol.bracket {
                counter-reset: list;
            }

            ol.bracket>li {
                list-style: none;
            }

            ol.bracket>li:before {
                content: counter(list) ") ";
                counter-increment: list;
                font-size: 1rem !important;
            }
        </style>
    @endpush
    @push('js')
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/mask/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/pages/transfer/create.js') }}"></script>
    @endpush
@endif
@if ($type == 'show')
    @push('js')
        <script src="{{ asset('assets/js/pages/transfer/form.js') }}"></script>
    @endpush
@endif
