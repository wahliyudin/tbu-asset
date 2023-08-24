@extends('layouts.master')

@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', 'Catalog')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Catalog
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Master</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Catalog</li>
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
                    <input type="text" data-kt-catalog-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Catalog" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-catalog-table-toolbar="base">
                    @permission('catalog_create')
                        <button type="button" class="btn btn-primary ps-4" data-bs-toggle="modal"
                            data-bs-target="#create-catalog">
                            <i class="ki-duotone ki-plus fs-2"></i>Tambah Catalog
                        </button>
                    @endpermission
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="catalog_table">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>Unit Model</th>
                        <th>Unit Type</th>
                        <th>Seri</th>
                        <th>Unit Class</th>
                        <th>Brand</th>
                        <th>Spesification</th>
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
    <div class="modal fade" id="create-catalog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form class="form" action="#" id="create-catalog_form">
                    <div class="modal-header" id="create-catalog_header">
                        <h2 class="fw-bold title">Tambah Catalog</h2>
                        <div id="create-catalog_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="row">
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Unit Model</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Unit Model"
                                    name="unit_model" />
                            </div>
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Unit Type</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Unit Type"
                                    name="unit_type" />
                            </div>
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Seri</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Seri"
                                    name="seri" />
                            </div>
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Unit Class</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Unit Class"
                                    name="unit_class" />
                            </div>
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Brand</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Brand"
                                    name="brand" />
                            </div>
                            <div class="col-md-6 fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Spesification</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Spesification"
                                    name="spesification" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" id="create-catalog_cancel" class="btn btn-light me-3">
                            Discard
                        </button>
                        <button type="submit" data-catalog="" id="create-catalog_submit" class="btn btn-primary">
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
    <script src="{{ asset('assets/js/pages/catalog/index.js') }}"></script>
@endpush
