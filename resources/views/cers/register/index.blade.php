@extends('layouts.master')

@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', 'Register Asset')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Register Asset
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Register Asset</li>
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
                    <input type="text" data-kt-cer-item-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Register Asset" />
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="cer_item_table">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-50px">No CER</th>
                        <th class="min-w-50px">Description</th>
                        <th class="min-w-125px">Model</th>
                        <th class="min-w-125px">Est. Umur</th>
                        <th class="min-w-125px">Quantity</th>
                        <th class="min-w-50px">Price</th>
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
    <div class="modal fade" id="timeline" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="timeline_header">
                    <h2 class="fw-bold">History Cer Item</h2>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-5 px-lg-5">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-duotone ki-disconnect fs-2 text-gray-500"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span></i>
                                </div>
                            </div>
                            <div class="timeline-content mb-10 mt-n1">
                                <div class="mb-5 pe-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="fs-5 fw-semibold text-gray-800 mb-2 d-flex align-items-center">
                                            <span>PR : </span>
                                            <span class="nopr ms-2"></span>
                                        </div>
                                        <span class="statuspr ms-2"></span>
                                    </div>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7 prdate"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-duotone ki-abstract-26 fs-2 text-gray-500"><span
                                            class="path1"></span><span class="path2"></span></i>
                                </div>
                            </div>
                            <div class="timeline-content mb-10 mt-n1">
                                <div class="pe-3 mb-5">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="fs-5 fw-semibold text-gray-800 mb-2 d-flex align-items-center">
                                            <span>PO : </span>
                                            <span class="nopo ms-2"></span>
                                        </div>
                                        <span class="statuspo ms-2"></span>
                                    </div>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7 podate"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-line w-40px"></div>
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-duotone ki-basket fs-2 text-gray-500"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span></i>
                                </div>
                            </div>
                            <div class="timeline-content mt-n1">
                                <div class="pe-3 mb-5">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="fs-5 fw-semibold text-gray-800 mb-2 d-flex align-items-center">
                                            <span>GR : </span>
                                            <span class="nogr ms-2"></span>
                                            <span class="link-doc-bast ms-2"></span>
                                        </div>
                                        <span class="statusgr ms-2"></span>
                                    </div>
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <div class="text-muted me-2 fs-7 grdate"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end">
                            @permission('asset_master_create')
                                <a href="" class="btn btn-sm btn-success ps-4 d-flex btn-register d-none">
                                    <i class="ki-duotone ki-add-files fs-3">
                                        <i class="path1"></i>
                                        <i class="path2"></i>
                                        <i class="path3"></i>
                                    </i>Register</a>
                            @endpermission
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/cer/register/index.js') }}"></script>
@endpush
