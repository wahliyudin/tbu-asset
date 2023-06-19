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
                    <input type="text" data-kt-asset-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Asset" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-asset-table-toolbar="base">
                    <button type="button" class="btn btn-primary ps-4" data-bs-toggle="modal"
                        data-bs-target="#create-asset">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Asset
                    </button>
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
@endsection

@push('modal')
    <div class="modal fade" id="create-asset" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form class="form" action="#" id="create-asset_form">
                    <div class="modal-header" id="create-asset_header">
                        <h2 class="fw-bold">Tambah Asset</h2>
                        <div id="create-asset_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="row">
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Unit</label>
                                <select class="form-select form-select-solid" name="unit_id" data-control="select2"
                                    data-placeholder="Unit" data-dropdown-parent="#create-asset">
                                    <option></option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->getKey() }}">{{ $unit->model }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Sub Cluster</label>
                                <select class="form-select form-select-solid" name="sub_cluster_id" data-control="select2"
                                    data-placeholder="Sub Cluster" data-dropdown-parent="#create-asset">
                                    <option></option>
                                    @foreach ($subClusters as $subCluster)
                                        <option value="{{ $subCluster->getKey() }}">{{ $subCluster->model }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Member Name</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Member Name"
                                    name="member_name" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">PIC</label>
                                <input type="text" class="form-control form-control-solid" placeholder="PIC"
                                    name="pic" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Activity</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Activity"
                                    name="activity" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Asset Location</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Asset Location"
                                    name="asset_location" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Kondisi</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Kondisi"
                                    name="kondisi" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">UOM</label>
                                <input type="text" class="form-control form-control-solid" placeholder="UOM"
                                    name="uom" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Quantity</label>
                                <input type="number" class="form-control form-control-solid" placeholder="Quantity"
                                    name="quantity" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Tanggal Bast</label>
                                <input class="form-control form-control-solid" placeholder="Tanggal Bast" name="tgl_bast"
                                    id="tgl_bast" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">HM</label>
                                <input type="text" class="form-control form-control-solid" placeholder="HM"
                                    name="hm" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">PR Number</label>
                                <input type="text" class="form-control form-control-solid" placeholder="PR Number"
                                    name="pr_number" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">PO Number</label>
                                <input type="text" class="form-control form-control-solid" placeholder="PO Number"
                                    name="po_number" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">GR Number</label>
                                <input type="text" class="form-control form-control-solid" placeholder="GR Number"
                                    name="gr_number" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Remark</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Remark"
                                    name="remark" />
                            </div>
                            <div class="col-md-4 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Status</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Status"
                                    name="status" />
                            </div>
                        </div>
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
                </form>
            </div>
        </div>
    </div>
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/asset/index.js') }}"></script>
@endpush
