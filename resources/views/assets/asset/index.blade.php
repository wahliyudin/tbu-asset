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
                    @permission('asset_master_create')
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
@endsection

@push('modal')
    <div class="modal fade" id="create-asset" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header" id="create-asset_header">
                    <h2 class="fw-bold">Tambah Asset</h2>
                    <div id="create-asset_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body px-lg-17" style="min-height: 761px;">
                    <form class="form" action="#" id="create-asset_form">
                        <ul class="nav nav-tabs nav-line-tabs flex-wrap border-transparent bg-gray-200 px-4 py-2 rounded">
                            <li class="nav-item my-1">
                                <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 active"
                                    data-bs-toggle="tab" href="#asset">
                                    Asset </a>
                            </li>
                            <li class="nav-item my-1">
                                <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 "
                                    data-bs-toggle="tab" href="#leasing">
                                    Leasing </a>
                            </li>
                            <li class="nav-item my-1">
                                <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 "
                                    data-bs-toggle="tab" href="#asuransi">
                                    Asuransi </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="asset" role="tabpanel">
                                <div class="card">
                                    <div class="card-body p-9">
                                        <div class="row">
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Kode</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Kode" name="kode" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7 unit">
                                                <label class="required fs-6 fw-semibold mb-2">Unit</label>
                                                <select class="form-select form-select-solid" name="unit_id"
                                                    data-control="select2" data-placeholder="Unit"
                                                    data-dropdown-parent=".unit">
                                                    <option></option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->getKey() }}">{{ $unit->model }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 fv-row mb-7 sub-cluster">
                                                <label class="required fs-6 fw-semibold mb-2">Sub Cluster</label>
                                                <select class="form-select form-select-solid" name="sub_cluster_id"
                                                    data-control="select2" data-placeholder="Sub Cluster"
                                                    data-dropdown-parent=".sub-cluster">
                                                    <option></option>
                                                    @foreach ($subClusters as $subCluster)
                                                        <option value="{{ $subCluster->getKey() }}">{{ $subCluster->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Member Name</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Member Name" name="member_name" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7 pic">
                                                <label class="required fs-6 fw-semibold mb-2">PIC</label>
                                                <select class="form-select form-select-solid" name="pic"
                                                    data-control="select2" data-placeholder="PIC"
                                                    data-dropdown-parent=".pic">
                                                    <option></option>
                                                    @foreach ($employees as $employee)
                                                        <option value="{{ $employee->nik }}">{{ $employee->nama_karyawan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Activity</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Activity" name="activity" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Asset Location</label>
                                                <input type="number" class="form-control form-control-solid"
                                                    placeholder="Asset Location" name="asset_location" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Kondisi</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Kondisi" name="kondisi" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">UOM</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="UOM" name="uom" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Quantity</label>
                                                <input type="number" class="form-control form-control-solid"
                                                    placeholder="Quantity" name="quantity" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Tanggal Bast</label>
                                                <input class="form-control form-control-solid" placeholder="Tanggal Bast"
                                                    name="tgl_bast" id="tgl_bast" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">HM</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="HM" name="hm" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">PR Number</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="PR Number" name="pr_number" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">PO Number</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="PO Number" name="po_number" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">GR Number</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="GR Number" name="gr_number" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Remark</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Remark" name="remark" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7 status">
                                                <label class="required fs-6 fw-semibold mb-2">Status</label>
                                                <select class="form-select form-select-solid" name="status"
                                                    data-control="select2" data-placeholder="Status"
                                                    data-dropdown-parent=".status">
                                                    <option></option>
                                                    @foreach (\App\Enums\Asset\Status::cases() as $status)
                                                        <option value="{{ $status->value }}">{{ $status->label() }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="leasing" role="tabpanel">
                                <div class="card">
                                    <div class="card-body p-9">
                                        <div class="row">
                                            <div class="col-md-4 fv-row mb-7 dealer">
                                                <label class="required fs-6 fw-semibold mb-2">Dealer</label>
                                                <select class="form-select form-select-solid" name="dealer_id_leasing"
                                                    data-control="select2" data-placeholder="Dealer"
                                                    data-dropdown-parent=".dealer">
                                                    <option></option>
                                                    @foreach ($dealers as $dealer)
                                                        <option value="{{ $dealer->getKey() }}">{{ $dealer->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 fv-row mb-7 leasing">
                                                <label class="required fs-6 fw-semibold mb-2">Leasing</label>
                                                <select class="form-select form-select-solid" name="leasing_id_leasing"
                                                    data-control="select2" data-placeholder="Leasing"
                                                    data-dropdown-parent=".leasing">
                                                    <option></option>
                                                    @foreach ($leasings as $leasing)
                                                        <option value="{{ $leasing->getKey() }}">{{ $leasing->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Harga Beli</label>
                                                <input type="text" class="form-control form-control-solid uang"
                                                    placeholder="Harga Beli" name="harga_beli_leasing" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Jangka Waktu</label>
                                                <div class="input-group input-group-solid">
                                                    <input type="number" class="form-control form-control-solid"
                                                        placeholder="Jangka Waktu" id="jangka_waktu_leasing"
                                                        name="jangka_waktu_leasing" />
                                                    <span class="input-group-text" id="jangka_waktu_leasing">
                                                        Bulan
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Biaya Leasing</label>
                                                <input type="text" class="form-control form-control-solid uang"
                                                    placeholder="Biaya Leasing" name="biaya_leasing" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Legalitas</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Legalitas" name="legalitas_leasing" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="asuransi" role="tabpanel">
                                <div class="card">
                                    <div class="card-body p-9">
                                        <div class="row">
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Jangka Waktu</label>
                                                <div class="input-group input-group-solid">
                                                    <input type="number" class="form-control form-control-solid"
                                                        placeholder="Jangka Waktu" id="jangka_waktu_insurance"
                                                        name="jangka_waktu_insurance" />
                                                    <span class="input-group-text" id="jangka_waktu_insurance">
                                                        Bulan
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Biaya</label>
                                                <input type="text" class="form-control form-control-solid uang"
                                                    placeholder="Biaya" name="biaya_insurance" />
                                            </div>
                                            <div class="col-md-4 fv-row mb-7">
                                                <label class="required fs-6 fw-semibold mb-2">Legalitas</label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Legalitas" name="legalitas_insurance" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/asset/index.js') }}"></script>
@endpush
