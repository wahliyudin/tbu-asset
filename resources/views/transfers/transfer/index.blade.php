@extends('layouts.master')

@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
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

@section('title', 'Transfer')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Transfer
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Transfer</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-transfer-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Transfer" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-transfer-table-toolbar="base">
                    {{-- <button type="button" class="btn btn-primary ps-4" data-bs-toggle="modal"
                        data-bs-target="#create-transfer">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Transfer
                    </button> --}}
                    <a href="{{ route('asset-transfers.create') }}" class="btn btn-primary ps-4">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Transfer
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="transfer_table">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Name</th>
                        <th class="text-end min-w-70px">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">

                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- @push('modal')
    <div class="modal fade" id="create-transfer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form class="form" action="#" id="create-transfer_form">
                    <div class="modal-header" id="create-transfer_header">
                        <h2 class="fw-bold">Tambah Transfer</h2>
                        <div id="create-transfer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
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
                                <h5>Dengan ini mengajukan permintaan pemindahan (transfer) asset dengan data berikut: (*)
                                </h5>
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
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" id="create-transfer_cancel" class="btn btn-light me-3">
                            Discard
                        </button>
                        <button type="submit" data-transfer="" id="create-transfer_submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Submit
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush --}}

@push('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/transfer/index.js') }}"></script>
@endpush
