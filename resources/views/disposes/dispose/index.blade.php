@extends('layouts.master')

@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', 'Dispose')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Dispose
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Dispose</li>
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
                    <input type="text" data-kt-dispose-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Dispose" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-dispose-table-toolbar="base">
                    <button type="button" class="btn btn-primary ps-4" data-bs-toggle="modal"
                        data-bs-target="#create-dispose">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Dispose
                    </button>
                    <a href="{{ route('asset-disposes.create') }}" class="btn btn-primary ps-4">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Dispose
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="dispose_table">
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

@push('modal')
    <div class="modal fade" id="create-dispose" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form class="form" action="#" id="create-dispose_form">
                    <div class="modal-header" id="create-dispose_header">
                        <h2 class="fw-bold">Tambah Dispose</h2>
                        <div id="create-dispose_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                                        PENGHAPUSAN ASSET
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
                                                TBU-FM-AST-002</td>
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
                            <div class="col-md-6">
                                <table class="w-100">
                                    <tbody>
                                        <tr>
                                            <td class="fs-6 fw-semibold w-150px">Department</td>
                                            <td>:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="fs-6 fw-semibold w-150px">Project</td>
                                            <td>:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="fs-6 fw-semibold w-150px">Division</td>
                                            <td>:</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="w-100">
                                    <tbody>
                                        <tr>
                                            <td class="fs-6 fw-semibold w-150px">Lokasi</td>
                                            <td>:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="fs-6 fw-semibold w-150px">Tanggal Pengajuan</td>
                                            <td>:</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <table class="table table-bordered border-gray-300">
                                    <thead>
                                        <tr class="text-center bg-secondary bg-opacity-50">
                                            <th>Deskripsi Asset</th>
                                            <th>Model & Spesifikasi</th>
                                            <th>Serial No. / Chasis No.</th>
                                            <th>Nomor Asset</th>
                                            <th>Tahun Buat / Beli</th>
                                            <th>Nilai Buku</th>
                                            <th>Estimasi Harga Pasar</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-center bg-secondary bg-opacity-50">
                                            <th colspan="8">Justifikasi / Alasan Dispose</th>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                <textarea name="justifikasi" class="form-control"></textarea>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
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
                        <div class="row mt-8">
                            <div class="col-md-12">
                                <div class="d-flex">
                                    <h5>Cara Pelaksanaan Penghapusan Asset Yang Ditentukan :</h5>
                                    <div class="d-flex flex-grow-1 align-items-center justify-content-evenly">
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" name="pelaksanaan" type="radio"
                                                value="" id="penjualan" />
                                            <label class="form-check-label fs-6 fw-semibold" for="penjualan">
                                                Penjualan
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" name="pelaksanaan" type="radio"
                                                value="" id="donasi" />
                                            <label class="form-check-label fs-6 fw-semibold" for="donasi">
                                                Donasi
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" name="pelaksanaan" type="radio"
                                                value="" id="pemusnahan" />
                                            <label class="form-check-label fs-6 fw-semibold" for="pemusnahan">
                                                Pemusnahan
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <h5>Keterangan :</h5>
                                    <ol style="font-style: italic;">
                                        <li>Setelah mendapatkan persetujuan penuh, beri tanda "X" pada kotak (a), (b) atau
                                            (c) atas
                                            pengurangan asset yang dimaksud:</li>
                                        <ol type='a'>
                                            <li><span class="fw-bold">Penjualan</span>, bila pengurangan asset tersebut
                                                dengan
                                                jalan dijual</li>
                                            <li><span class="fw-bold">Donasi</span>, bila pengurangan asset dengan tujuan
                                                kemanusiaan, pendidikan atau tujuan sosial lainnya</li>
                                            <li><span class="fw-bold">Pemusnahan</span>, bila asset tersebut tidak memiliki
                                                nilai
                                                ekonomis atau tidak dapat dijual kembali</li>
                                        </ol>
                                        <li>Sertakan foto-foto atas asset yang akan di-dispose.</li>
                                        <li>Penawaran dari calon pembeli (jika pilihan a) harus dilampirkankan untuk
                                            mendapatkan
                                            persetujuan.</li>
                                        <li>Proposal penghapusan asset harus dibuat setelah form ini disetujui.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" id="create-dispose_cancel" class="btn btn-light me-3">
                            Discard
                        </button>
                        <button type="submit" data-dispose="" id="create-dispose_submit" class="btn btn-primary">
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
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dispose/index.js') }}"></script>
@endpush
