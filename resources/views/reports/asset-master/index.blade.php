@extends('layouts.master')

@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', 'Asset Master')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Asset Master
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Report</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Asset Master</li>
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
                    <input type="search" name="search" data-kt-asset-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Asset Master" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end gap-2" data-kt-asset-table-toolbar="base">
                    <button type="button" class="btn btn-info ps-4 export">
                        <span class="indicator-label">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-file-up fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>Export
                            </div>
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary ps-4" data-bs-toggle="modal"
                        data-bs-target="#filter-asset">
                        <i class="ki-duotone ki-filter fs-2">
                            <i class="path1"></i>
                            <i class="path2"></i>
                        </i>Filter Asset
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="asset_table">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Id Asset</th>
                        <th class="min-w-125px">Kode Unit</th>
                        <th class="min-w-125px">Type</th>
                        <th class="min-w-125px">Seri</th>
                        <th class="min-w-125px">Class</th>
                        <th class="min-w-125px">Brand</th>
                        <th class="min-w-125px">Serial Number</th>
                        <th class="min-w-125px">Spesification</th>
                        <th class="min-w-125px">Tahun Pembuatan</th>
                        <th class="min-w-125px">Kelengkapan Tambahan</th>
                        <th class="min-w-125px">Category</th>
                        <th class="min-w-125px">Cluster</th>
                        <th class="min-w-125px">Sub Cluster</th>
                        <th class="min-w-125px">PIC</th>
                        <th class="min-w-125px">Activity</th>
                        <th class="min-w-125px">Asset Location</th>
                        <th class="min-w-125px">Department</th>
                        <th class="min-w-125px">Condition</th>
                        <th class="min-w-125px">Uom</th>
                        <th class="min-w-125px">Quantity</th>
                        <th class="min-w-125px">Masa Pakai</th>
                        <th class="min-w-125px">Nilai Sisa</th>
                        <th class="min-w-125px">Tanggal BAST</th>
                        <th class="min-w-125px">HM</th>
                        <th class="min-w-125px">PR Number</th>
                        <th class="min-w-125px">PO Number</th>
                        <th class="min-w-125px">GR Number</th>
                        <th class="min-w-125px">Status Asset</th>
                        <th class="min-w-125px">Status</th>
                        <th class="min-w-125px">Remark</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">

                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('modal')
    <div class="modal fade" id="filter-asset" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="filter-asset_header">
                    <h2 class="fw-bold title">Filter Asset</h2>
                    <div id="filter-asset_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="filter">
                        <div class="row">
                            <div class="col-md-4 status_asset">
                                <label class="required fs-6 fw-semibold mb-2">Status Asset</label>
                                <select class="form-select form-select" name="status_asset" data-control="select2"
                                    data-placeholder="All" data-dropdown-parent=".status_asset">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-md-4 status">
                                <label class="required fs-6 fw-semibold mb-2">Status</label>
                                <select class="form-select form-select" name="status" data-control="select2"
                                    data-placeholder="All" data-dropdown-parent=".status" data-allow-clear="true">
                                    <option></option>
                                    @foreach (\App\Enums\Asset\Status::cases() as $status)
                                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 project">
                                <label class="required fs-6 fw-semibold mb-2">Project</label>
                                <select class="form-select form-select" name="project" data-control="select2"
                                    data-placeholder="All" data-dropdown-parent=".project" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->project_id }}">{{ $project->project }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-2 category">
                                <label class="required fs-6 fw-semibold mb-2">Category</label>
                                <select class="form-select form-select" name="category" data-control="select2"
                                    data-placeholder="All" data-dropdown-parent=".category" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-2 cluster">
                                <label class="required fs-6 fw-semibold mb-2">Cluster</label>
                                <select class="form-select form-select" name="cluster" data-control="select2"
                                    data-placeholder="All" data-dropdown-parent=".cluster" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($clusters as $cluster)
                                        <option value="{{ $cluster->id }}">{{ $cluster->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-2 subCluster">
                                <label class="required fs-6 fw-semibold mb-2">Sub Cluster</label>
                                <select class="form-select form-select" name="sub_cluster" data-control="select2"
                                    data-placeholder="All" data-dropdown-parent=".subCluster" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($subClusters as $subCluster)
                                        <option value="{{ $subCluster->id }}">{{ $subCluster->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" id="filter-asset_cancel" class="btn btn-light me-3">
                        Batal
                    </button>
                    <button type="submit" data-asset="" id="filter-asset_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Filter
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
    <script src="{{ asset('assets/js/pages/reports/asset-master/index.js') }}"></script>
@endpush
