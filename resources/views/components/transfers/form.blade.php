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
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary ps-3 btn-select-asset">
                    <i class="ki-duotone ki-search-list fs-2">
                        <i class="path1"></i>
                        <i class="path2"></i>
                        <i class="path3"></i>
                    </i>Pilih Asset</button>
            </div>
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
                        <td id="merk_tipe_model">{{ $assetTransfer->asset?->unit?->brand }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Serial Number Asset</td>
                        <td style="width: 10px;">:</td>
                        <td id="serial_number">{{ $assetTransfer->asset?->unit?->serial_number }}</td>
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
                        <td id="kelengkapan">{{ $assetTransfer->asset?->unit?->spesification }}</td>
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
                        <td class="p-1 w-50px">2</td>
                        <td class="p-1 w-50px">8</td>
                        <td class="p-1 w-50px">-</td>
                        <td class="p-1 w-50px">0</td>
                        <td class="p-1 w-50px">6</td>
                        <td class="p-1 w-50px">-</td>
                        <td class="p-1 w-50px">2</td>
                        <td class="p-1 w-50px">0</td>
                        <td class="p-1 w-50px">2</td>
                        <td class="p-1 w-50px">3</td>
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
    <div class="row mt-4">
        <h5>Pemindahan (Transfer) Asset Perusahaan : </h5>
        <div class="d-flex flex-column gap-2 ps-10">
            <div class="form-check form-check-custom">
                <input class="form-check-input" name="pelaksanaan" type="radio" value="" id="" />
                <label class="form-check-label fs-6 fw-semibold text-black" for="">
                    Disetujui
                </label>
            </div>
            <div class="form-check form-check-custom">
                <input class="form-check-input" name="pelaksanaan" type="radio" value="" id="" />
                <label class="form-check-label fs-6 fw-semibold text-black" for="">
                    Tidak Disetujui, karena alasan sebagai berikut :
                </label>
            </div>
            <div class="ps-10">
                <textarea name="" id="" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <h5>Tanggal Pemindahan (Transfer) :</h5>
        <div class="col-md-5 ps-14">
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
                        <td class="p-1 w-50px"></td>
                        <td class="p-1 w-50px"></td>
                        <td class="p-1 w-50px">-</td>
                        <td class="p-1 w-50px"></td>
                        <td class="p-1 w-50px"></td>
                        <td class="p-1 w-50px">-</td>
                        <td class="p-1 w-50px"></td>
                        <td class="p-1 w-50px"></td>
                        <td class="p-1 w-50px"></td>
                        <td class="p-1 w-50px"></td>
                    </tr>
                </tbody>
            </table>
            <p class="m-0">(Diisi apabila proses transfer disetujui)</p>
        </div>
    </div>
    @if ($type == 'show')
        <div class="row mt-8">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    @foreach ($assetTransfer->workflows as $workflow)
                        <div class="d-flex flex-column w-150px {{ $workflow->last_action == \App\Enums\Workflows\LastAction::APPROV ? 'bg-success' : ($workflow->last_action == \App\Enums\Workflows\LastAction::REJECT ? 'bg-danger' : 'bg-warning') }}"
                            style="border-radius: {{ $workflow->sequence == 1 ? '10px 0 0 10px' : ($workflow->sequence == count($assetTransfer->workflows) ? '0 10px 10px 0' : '0 0 0 0') }}; overflow: hidden;">
                            <div class="border text-center text-white p-1 d-flex flex-column">
                                <p class="m-0 fw-bold" style="font-size: 12px;">
                                    {{ $workflow->title }}
                                    By
                                </p>
                                <p class="m-0">{{ $workflow?->employee?->nama_karyawan }}</p>
                            </div>
                            <div class="border text-center text-white p-1 d-flex flex-column">
                                <p class="m-0 fw-bold" style="font-size: 12px;">
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
            <div class="col-md-12 d-flex justify-content-start mt-4">
                @permission('asset_transfer_approv')
                    <button {{ !$isCurrentWorkflow ? 'disabled' : '' }} type="button"
                        data-transfer="{{ $assetTransfer->id }}" class="btn btn-success ps-4 approv">
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
                    <button {{ !$isCurrentWorkflow ? 'disabled' : '' }} type="button"
                        data-transfer="{{ $assetTransfer->id }}" class="btn btn-danger ms-2 ps-4 reject">
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
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary simpan-form-transfer">
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
