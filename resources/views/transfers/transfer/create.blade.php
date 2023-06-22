@extends('layouts.master')

@section('title', 'Create Asset Transfer')

@push('css')
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

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Asset Transfer
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('asset-transfers.index') }}" class="text-muted text-hover-primary">
                            Asset Transfer </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Create Asset Transfer</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="" class="form-transfer">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <img src="{{ asset('assets/media/logos/tbu.png') }}" style="width: 100%;" alt="">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column">
                            <h5 class="fw-bold text-center" style="text-transform: uppercase;">tbu
                                management
                                system</h5>
                            <h6 class="fw-bold text-center" style="text-transform: uppercase;">formulir <br>
                                TRANSFER ASSET
                            </h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="py-0" style="font-size: 14px;">Nomor</td>
                                    <td class="py-0 px-2">:</td>
                                    <td class="py-0" style="font-size: 14px; white-space: nowrap;">
                                        TBU-FM-AST-003</td>
                                </tr>
                                <tr>
                                    <td class="py-0" style="font-size: 14px; white-space: nowrap;">Tanggal
                                        Terbit</td>
                                    <td class="py-0 px-2">:</td>
                                    <td class="py-0" style="font-size: 14px;">12-04-2023</td>
                                </tr>
                                <tr>
                                    <td class="py-0" style="font-size: 14px;">Revisi</td>
                                    <td class="py-0 px-2">:</td>
                                    <td class="py-0" style="font-size: 14px;">00</td>
                                </tr>
                                <tr>
                                    <td class="py-0" style="font-size: 14px;">Halaman</td>
                                    <td class="py-0 px-2">:</td>
                                    <td class="py-0" style="font-size: 14px;">1 dari 1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Dengan ini mengajukan permintaan pemindahan (transfer) asset dengan data berikut: (*)</h5>
                        <table class="w-100 ms-8 mt-4">
                            <tbody>
                                <tr>
                                    <td class="fs-6 fw-semibold w-200px">Nama Asset</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold w-200px">Merk/Tipe/Model</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold w-200px">Serial Number Asset</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold w-200px">Nomor Asset</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold w-200px">Nilai Akuisisi / Nilai Buku</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold w-200px">Kelengkapan Asset</td>
                                    <td>:</td>
                                    <td></td>
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
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th class="bg-secondary bg-opacity-50 w-200px">Department</th>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th class="bg-secondary bg-opacity-50 w-200px">Division</th>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th class="bg-secondary bg-opacity-50 w-200px">Project</th>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th class="bg-secondary bg-opacity-50 w-200px">Lokasi</th>
                                    <td></td>
                                    <td></td>
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
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(`.form-transfer`).on('click', `.simpan-form-transfer`, function(e) {
                e.preventDefault();
                var postData = new FormData($(`.form-transfer`)[0]);
                $(`.simpan-form-transfer`).attr("data-kt-indicator", "on");
                $.ajax({
                    type: 'POST',
                    url: "/settings/approval/store",
                    processData: false,
                    contentType: false,
                    data: postData,
                    success: function(response) {
                        $(`.simpan-form-transfer`).removeAttr("data-kt-indicator");
                        Swal.fire(
                            'Success!',
                            response.message,
                            'success'
                        ).then(function() {
                            location.reload();
                        });
                    },
                    error: function(jqXHR, xhr, textStatus, errorThrow, exception) {
                        $(`.simpan-form-transfer`).removeAttr("data-kt-indicator");
                        if (jqXHR.status == 422) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan!',
                                text: JSON.parse(jqXHR.responseText)
                                    .message,
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: jqXHR.responseText,
                            })
                        }
                    }
                });
            });
        });
    </script>
@endpush
