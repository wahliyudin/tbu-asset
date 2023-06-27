@extends('layouts.master')

@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', 'Cer')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Cer
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Cer</li>
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
                    <input type="text" data-kt-cer-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Cer" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-cer-table-toolbar="base">
                    {{-- <button type="button" class="btn btn-primary ps-4" data-bs-toggle="modal" data-bs-target="#create-cer">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Cer
                    </button> --}}
                    @permission('asset_request_create')
                        <a href="{{ route('asset-requests.create') }}" class="btn btn-primary ps-4">
                            <i class="ki-duotone ki-plus fs-2"></i>Tambah Cer
                        </a>
                    @endpermission
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="cer_table">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-50px">Type Budget</th>
                        <th class="min-w-125px">Budget Ref</th>
                        <th class="min-w-125px">Peruntukan</th>
                        <th class="min-w-125px">Tanggal Kebutuhan</th>
                        <th class="min-w-50px">Sumber Pendanaan</th>
                        <th class="min-w-50px">Status</th>
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
    <div class="modal fade" id="create-cer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form class="form" action="#" id="create-cer_form">
                    <div class="modal-header" id="create-cer_header">
                        <h2 class="fw-bold">Tambah Cer</h2>
                        <div id="create-cer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                                        CAPITAL EXPENDITURE REQUEST
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
                                                TBU-FM-AST-001</td>
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
                                            <td class="fs-6 fw-semibold">Peruntukan</td>
                                            <td>:</td>
                                            <td>
                                                <div class="form-check form-check-custom">
                                                    <input class="form-check-input" name="peruntukan" type="radio"
                                                        value="" id="penggantian" />
                                                    <label class="form-check-label fs-6 fw-semibold" for="penggantian">
                                                        Penggantian
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="form-check form-check-custom">
                                                    <input class="form-check-input" name="peruntukan" type="radio"
                                                        value="" id="penambahan" />
                                                    <label class="form-check-label fs-6 fw-semibold" for="penambahan">
                                                        Penambahan
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="form-check form-check-custom">
                                                    <input class="form-check-input" name="peruntukan" type="radio"
                                                        value="" id="safety" />
                                                    <label class="form-check-label fs-6 fw-semibold" for="safety">
                                                        Safety
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="w-100">
                                    <tbody>
                                        <tr>
                                            <td class="fs-6 fw-semibold">Status</td>
                                            <td>:</td>
                                            <td>
                                                <div class="form-check form-check-custom">
                                                    <input class="form-check-input" name="status" type="radio"
                                                        value="" id="budgeted" />
                                                    <label class="form-check-label fs-6 fw-semibold" for="budgeted">
                                                        Budgeted
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="form-check form-check-custom">
                                                    <input class="form-check-input" name="status" type="radio"
                                                        value="" id="nonbudgeted" />
                                                    <label class="form-check-label fs-6 fw-semibold" for="nonbudgeted">
                                                        Non Budgeted
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <table class="w-100">
                                    <tbody>
                                        <tr>
                                            <td class="fs-6 fw-semibold">Department</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fs-6 fw-semibold">Project</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fs-6 fw-semibold">Lokasi</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" class="form-control">
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
                                                <input type="text" class="form-control date">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fs-6 fw-semibold">Tanggal Kebutuhan</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" class="form-control date">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex flex-column mt-4 me-4">
                            <div class="d-flex flex-column">
                                <h5>1. Justifikasi / alasan pengadaan</h5>
                                <textarea name="justifikasi" class="form-control ms-4"></textarea>
                            </div>
                            <div class="d-flex flex-column mt-4">
                                <h5>2. Items</h5>
                                <div class="table-responsive ms-4" style="margin-right: -10px;">
                                    <table class="table table-bordered border-gray-300">
                                        <thead>
                                            <tr class="fw-bold text-center bg-secondary bg-opacity-50">
                                                <th class="fs-6 fw-semibold w-200px">Asset Description</th>
                                                <th class="fs-6 fw-semibold w-200px">Asset Model</th>
                                                <th class="fs-6 fw-semibold w-200px">Est. Umur Asset</th>
                                                <th class="fs-6 fw-semibold w-100px">Asset Qty</th>
                                                <th class="fs-6 fw-semibold w-200px">Unit Price</th>
                                                <th class="fs-6 fw-semibold w-200px">Sub Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" min="1" class="form-control">
                                                        <span class="input-group-text">Bulan</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" min="1" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" readonly class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" readonly class="form-control">
                                                </td>
                                            </tr>
                                        </tbody>
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
                                                <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">IDR</td>
                                                <td class="w-200px"></td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">USD</td>
                                                <td class="w-200px"></td>
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
                                    <div class="d-flex align-items-center justify-content-evenly w-100">
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" name="sumber_pendanaan" type="radio"
                                                value="" id="leasing" />
                                            <label class="form-check-label fs-6 fw-semibold" for="leasing">
                                                Leasing
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" name="sumber_pendanaan" type="radio"
                                                value="" id="bukanleasing" />
                                            <label class="form-check-label fs-6 fw-semibold" for="bukanleasing">
                                                Bukan Leasing
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <h5>5. Badget</h5>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered w-100 border-gray-300">
                                        <tbody>
                                            <tr>
                                                <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">Ref No</td>
                                                <td class="w-200px"></td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">Periode
                                                    (tahun)
                                                </td>
                                                <td class="w-200px"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4 pe-0">
                                    <table class="table table-bordered w-100 border-gray-300">
                                        <tbody>
                                            <tr>
                                                <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">IDR</td>
                                                <td class="w-200px"></td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">USD</td>
                                                <td class="w-200px"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex flex-column mt-4">
                                <h5>6. Cost & Benefit Analyst</h5>
                                <textarea name="justifikasi" class="form-control ms-4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" id="create-cer_cancel" class="btn btn-light me-3">
                            Discard
                        </button>
                        <button type="submit" data-cer="" id="create-cer_submit" class="btn btn-primary">
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
    <script src="{{ asset('assets/js/pages/cer/index.js') }}"></script>
@endpush
