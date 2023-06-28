<form action="" class="form-transfer">
    <x-form-header title="TRANSFER ASSET" nomor="TBU-FM-AST-003" tanggal="12-04-2023" revisi="00" halaman="1 dari 1" />
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
                        <td id="nama">Example</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Merk/Tipe/Model</td>
                        <td style="width: 10px;">:</td>
                        <td id="merk_tipe_model">Example</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Serial Number Asset</td>
                        <td style="width: 10px;">:</td>
                        <td id="serial_number">Example</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Nomor Asset</td>
                        <td style="width: 10px;">:</td>
                        <td id="nomor_asset">Example</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Nilai Akuisisi / Nilai Buku
                        </td>
                        <td style="width: 10px;">:</td>
                        <td id="niali_buku">Example</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;" class="fs-6 fw-semibold w-200px">Kelengkapan Asset</td>
                        <td style="width: 10px;">:</td>
                        <td id="kelengkapan">Example</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-8">
        <div class="col-md-12 ps-12">
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
                        <td>Example dfhsdf jsdf sdfj</td>
                        <td>Example dfhsdf jsdf sdfj</td>
                    </tr>
                    <tr>
                        <th class="bg-secondary bg-opacity-50 w-200px">Department</th>
                        <td>Example dfhsdf jsdf sdfj</td>
                        <td>Example dfhsdf jsdf sdfj</td>
                    </tr>
                    <tr>
                        <th class="bg-secondary bg-opacity-50 w-200px">Division</th>
                        <td>Example dfhsdf jsdf sdfj</td>
                        <td>Example dfhsdf jsdf sdfj</td>
                    </tr>
                    <tr>
                        <th class="bg-secondary bg-opacity-50 w-200px">Project</th>
                        <td>Example dfhsdf jsdf sdfj</td>
                        <td>Example dfhsdf jsdf sdfj</td>
                    </tr>
                    <tr>
                        <th class="bg-secondary bg-opacity-50 w-200px">Lokasi</th>
                        <td>Example dfhsdf jsdf sdfj</td>
                        <td>Example dfhsdf jsdf sdfj</td>
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
        <ol class="bracket">
            <li class="d-flex align-items-center gap-6">
                <input type="text" class="form-control mt-1">
            </li>
            <li class="d-flex align-items-center gap-6">
                <input type="text" class="form-control mt-1">
            </li>
            <li class="d-flex align-items-center gap-6">
                <input type="text" class="form-control mt-1">
            </li>
        </ol>
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
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
                <div class="d-flex flex-column bg-success w-200px"
                    style="border-radius: 10px 0 0 10px; overflow: hidden;">
                    <div class="border text-center text-white p-1 d-flex flex-column">
                        <p class="m-0 fw-bold" style="font-size: 15px;">
                            Title
                            By
                        </p>
                        <p class="m-0">Nama Karyawan</p>
                    </div>
                    <div class="border text-center text-white p-1 d-flex flex-column">
                        <p class="m-0 fw-bold" style="font-size: 15px;">
                            Title
                            On
                        </p>
                        <p class="m-0">
                            Tanggal
                        </p>
                    </div>
                </div>
                <div class="d-flex flex-column bg-success w-200px"
                    style="border-radius: 0 10px 10px 0; overflow: hidden;">
                    <div class="border text-center text-white p-1 d-flex flex-column">
                        <p class="m-0 fw-bold" style="font-size: 15px;">
                            Title
                            By
                        </p>
                        <p class="m-0">Nama Karyawan</p>
                    </div>
                    <div class="border text-center text-white p-1 d-flex flex-column">
                        <p class="m-0 fw-bold" style="font-size: 15px;">
                            Title
                            On
                        </p>
                        <p class="m-0">
                            Tanggal
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
</form>
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
    <script src="{{ asset('assets/js/pages/transfer/create.js') }}"></script>
@endpush
