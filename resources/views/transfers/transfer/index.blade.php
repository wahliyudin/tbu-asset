@extends('layouts.master')

@push('css')
    <style>
        .swal2-container {
            z-index: 999999 !important;
        }
    </style>
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
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
                    <input type="text" data-kt-transfer-table-filter="search" name="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Transfer" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-transfer-table-toolbar="base">
                    @permission('asset_transfer_create')
                        <a href="{{ route('asset-transfers.create') }}" class="btn btn-primary ps-4">
                            <i class="ki-duotone ki-plus fs-2"></i>Tambah Transfer
                        </a>
                    @endpermission
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="transfer_table">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">No Transfer</th>
                        <th class="min-w-125px">Asset</th>
                        <th class="min-w-125px">Old Pic</th>
                        <th class="min-w-125px">New Pic</th>
                        <th class="min-w-125px">Status Transfer</th>
                        <th class="min-w-70px">Status Approval</th>
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
    <div class="modal fade" id="received" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="received_header">
                    <h2 class="fw-bold">Form Received</h2>
                    <div id="received_close" class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form" action="#" id="received_form">
                        <div class="row">
                            <div class="col-md-6 mb-7">
                                <label class="required fw-semibold mb-2">Tanggal BAST</label>
                                <input class="form-control" placeholder="Tanggal BAST" name="tanggal_bast"
                                    id="tanggal_bast" />
                            </div>
                            <div class="col-md-6 mb-7">
                                <label class="required fw-semibold mb-2">No BAST</label>
                                <input class="form-control" placeholder="No BAST" name="no_bast" id="no_bast" />
                            </div>
                            <div class="col-md-12 mb-7">
                                <label class="required fw-semibold mb-2">File BAST</label>
                                <input type="file" name="file_bast" class="form-control" accept=".doc, .docx, .pdf">
                            </div>
                        </div>
                        <div class="separator separator-dashed mb-7"></div>
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-4 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" data-kt-budget-table-filter="search" name="search"
                                class="form-control text-sm w-250px ps-13" placeholder="Cari Budget" />
                        </div>
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="budgets_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Remaining</th>
                                    <th class="min-w-125px">Description</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" id="received_cancel" class="btn btn-light me-3">
                        Discard
                    </button>
                    <button type="button" id="received_submit" data-transfer="" class="btn btn-primary">
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
    <script src="{{ asset('assets/js/pages/transfer/index.js') }}"></script>
@endpush
