@extends('layouts.master')

@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', 'Asset')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Asset
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Master</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Asset</li>
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
                    <input type="text" name="search" data-kt-asset-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Asset" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-asset-table-toolbar="base">
                    @permission('asset_master_create')
                        <a href="{{ route('asset-masters.format') }}" class="btn btn-secondary me-4">Download Format</a>
                        <button type="button" class="btn btn-info ps-4 me-4" data-bs-toggle="modal"
                            data-bs-target="#import-asset">
                            <i class="ki-duotone ki-cloud-download fs-2">
                                <i class="path1"></i>
                                <i class="path2"></i>
                            </i>Import Asset
                        </button>
                        <button type="button" class="btn btn-primary ps-4" data-bs-toggle="modal"
                            data-bs-target="#create-asset">
                            <i class="ki-duotone ki-plus fs-2"></i>Tambah Asset
                        </button>
                    @endpermission
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="asset_table">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>Kode Asset</th>
                        <th>Kode Unit</th>
                        <th>Unit Model</th>
                        <th>Unit Type</th>
                        <th>Asset Location</th>
                        <th>PIC</th>
                        <th class="text-end min-w-70px">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">

                </tbody>
            </table>
        </div>
    </div>
    <div style="position: fixed; bottom: 10px; right: 10px; width: 400px; z-index: 99999;" class="notif-progress d-none">
        <div class="card" style="position: relative;">
            <span class="btn-close-progress" style="position: absolute; top: 10px; right: 10px; cursor: pointer;">
                <i class="ki-duotone ki-cross-circle fs-1">
                    <i class="path1"></i>
                    <i class="path2"></i>
                </i>
            </span>
            <div class="card-body">
                <span id="title">Uploading... </span>
                <span id="desc"></span>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success notif-progress-line"
                        role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        0%</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    <div class="modal fade" id="create-asset" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header" id="create-asset_header">
                    <h2 class="fw-bold title">Tambah Asset</h2>
                    <div id="create-asset_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body px-lg-17" style="min-height: 761px;">
                    <form class="form" action="#" id="create-asset_form">
                        <x-assets.form :projects="$projects" :uoms="$uoms" :units="$units" :subClusters="$subClusters"
                            :employees="$employees" :dealers="$dealers" :leasings="$leasings" />
                    </form>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" id="create-asset_cancel" class="btn btn-light me-3">
                        Discard
                    </button>
                    <button type="submit" data-asset="" id="create-asset_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="import-asset" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content">
                <div class="modal-header" id="import-asset_header">
                    <h2 class="fw-bold">Import Asset</h2>
                    <div id="import-asset_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body px-lg-17">
                    <form class="form" action="#" id="import-asset_form">
                        <input type="file" name="file" class="form-control"
                            accept=".xls, .xlsx, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    </form>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" id="import-asset_cancel" class="btn btn-light me-3">
                        Discard
                    </button>
                    <button type="button" id="import-asset_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jquery.mask.min.js') }}"></script>
    {{-- @vite('resources/js/app.js') --}}
    <script src="{{ asset('assets/js/pages/asset/index.js') }}"></script>
@endpush
