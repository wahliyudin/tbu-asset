@extends('layouts.master')

@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', 'History Transfer')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data History Transfer
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">History Transfer</li>
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
                    <input type="text" data-kt-history-transfer-table-filter="search" name="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari History Transfer" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-history-transfer-table-toolbar="base">

                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="history_transfer_table">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">ID Asset</th>
                        <th class="min-w-125px">Model</th>
                        <th class="min-w-125px">Type</th>
                        <th class="min-w-125px">PIC</th>
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
                    <h2 class="fw-bold">History Asset Transfer</h2>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-5 px-lg-5">
                    <div class="px-4 py-4 mh-500px scroll-y ">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-line w-40px" style="border-left-color: var(--bs-gray-400);"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px">
                                    <div class="symbol-label" style="background-color: var(--bs-gray-200) !important;">
                                        <i class="ki-duotone ki-check fs-2"></i>
                                    </div>
                                </div>
                                <div class="timeline-content">
                                    <div class="pb-5 pe-3">
                                        <div class="border border-dashed border-gray-300 rounded px-7 py-3">
                                            <!--begin::Info-->
                                            <div class="d-flex flex-stack mb-3">
                                                <!--begin::Wrapper-->
                                                <div class="me-3">
                                                    <!--begin::Icon-->
                                                    <img src="../assets/media/stock/ecommerce/210.gif"
                                                        class="w-50px ms-n1 me-1" alt="">
                                                    <!--end::Icon-->

                                                    <!--begin::Title-->
                                                    <a href="../apps/ecommerce/catalog/edit-product.html"
                                                        class="text-gray-800 text-hover-primary fw-bold">Elephant
                                                        1802</a>
                                                    <!--end::Title-->
                                                </div>
                                                <!--end::Wrapper-->

                                                <!--begin::Action-->
                                                <div class="m-0">
                                                    <!--begin::Menu-->
                                                    <button
                                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                        data-kt-menu-overflow="true">

                                                        <i class="ki-duotone ki-dots-square fs-1"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span></i>
                                                    </button>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                                        data-kt-menu="true" style="">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">
                                                                Quick Actions</div>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu separator-->
                                                        <div class="separator mb-3 opacity-75"></div>
                                                        <!--end::Menu separator-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Ticket
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Customer
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                            data-kt-menu-placement="right-start">
                                                            <!--begin::Menu item-->
                                                            <a href="#" class="menu-link px-3">
                                                                <span class="menu-title">New Group</span>
                                                                <span class="menu-arrow"></span>
                                                            </a>
                                                            <!--end::Menu item-->

                                                            <!--begin::Menu sub-->
                                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Admin Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Staff Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Member Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu sub-->
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Contact
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu separator-->
                                                        <div class="separator mt-3 opacity-75"></div>
                                                        <!--end::Menu separator-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content px-3 py-3">
                                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                                    Generate Reports
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>

                                                    <!--begin::Menu 2-->

                                                    <!--end::Menu 2-->

                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::Action-->
                                            </div>
                                            <!--end::Info-->

                                            <!--begin::Customer-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Name-->
                                                <span class="text-gray-400 fw-bold">To:
                                                    <a href="../apps/ecommerce/sales/details.html"
                                                        class="text-gray-800 text-hover-primary fw-bold">
                                                        Jason Bourne </a>
                                                </span>
                                                <!--end::Name-->

                                                <!--begin::Label-->
                                                <span class="badge badge-light-success">Delivered</span>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Customer-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-line w-40px" style="border-left-color: var(--bs-gray-400);"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px">
                                    <div class="symbol-label" style="background-color: var(--bs-gray-200) !important;">
                                        <i class="ki-duotone ki-check fs-2"></i>
                                    </div>
                                </div>
                                <div class="timeline-content">
                                    <div class="pb-5 pe-3">
                                        <div class="border border-dashed border-gray-300 rounded px-7 py-3">
                                            <!--begin::Info-->
                                            <div class="d-flex flex-stack mb-3">
                                                <!--begin::Wrapper-->
                                                <div class="me-3">
                                                    <!--begin::Icon-->
                                                    <img src="../assets/media/stock/ecommerce/210.gif"
                                                        class="w-50px ms-n1 me-1" alt="">
                                                    <!--end::Icon-->

                                                    <!--begin::Title-->
                                                    <a href="../apps/ecommerce/catalog/edit-product.html"
                                                        class="text-gray-800 text-hover-primary fw-bold">Elephant
                                                        1802</a>
                                                    <!--end::Title-->
                                                </div>
                                                <!--end::Wrapper-->

                                                <!--begin::Action-->
                                                <div class="m-0">
                                                    <!--begin::Menu-->
                                                    <button
                                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                        data-kt-menu-overflow="true">

                                                        <i class="ki-duotone ki-dots-square fs-1"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span></i>
                                                    </button>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                                        data-kt-menu="true" style="">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">
                                                                Quick Actions</div>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu separator-->
                                                        <div class="separator mb-3 opacity-75"></div>
                                                        <!--end::Menu separator-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Ticket
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Customer
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                            data-kt-menu-placement="right-start">
                                                            <!--begin::Menu item-->
                                                            <a href="#" class="menu-link px-3">
                                                                <span class="menu-title">New Group</span>
                                                                <span class="menu-arrow"></span>
                                                            </a>
                                                            <!--end::Menu item-->

                                                            <!--begin::Menu sub-->
                                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Admin Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Staff Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Member Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu sub-->
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Contact
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu separator-->
                                                        <div class="separator mt-3 opacity-75"></div>
                                                        <!--end::Menu separator-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content px-3 py-3">
                                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                                    Generate Reports
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>

                                                    <!--begin::Menu 2-->

                                                    <!--end::Menu 2-->

                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::Action-->
                                            </div>
                                            <!--end::Info-->

                                            <!--begin::Customer-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Name-->
                                                <span class="text-gray-400 fw-bold">To:
                                                    <a href="../apps/ecommerce/sales/details.html"
                                                        class="text-gray-800 text-hover-primary fw-bold">
                                                        Jason Bourne </a>
                                                </span>
                                                <!--end::Name-->

                                                <!--begin::Label-->
                                                <span class="badge badge-light-success">Delivered</span>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Customer-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-line w-40px" style="border-left-color: var(--bs-gray-400);"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px">
                                    <div class="symbol-label" style="background-color: var(--bs-gray-200) !important;">
                                        <i class="ki-duotone ki-check fs-2"></i>
                                    </div>
                                </div>
                                <div class="timeline-content">
                                    <div class="pb-5 pe-3">
                                        <div class="border border-dashed border-gray-300 rounded px-7 py-3">
                                            <!--begin::Info-->
                                            <div class="d-flex flex-stack mb-3">
                                                <!--begin::Wrapper-->
                                                <div class="me-3">
                                                    <!--begin::Icon-->
                                                    <img src="../assets/media/stock/ecommerce/210.gif"
                                                        class="w-50px ms-n1 me-1" alt="">
                                                    <!--end::Icon-->

                                                    <!--begin::Title-->
                                                    <a href="../apps/ecommerce/catalog/edit-product.html"
                                                        class="text-gray-800 text-hover-primary fw-bold">Elephant
                                                        1802</a>
                                                    <!--end::Title-->
                                                </div>
                                                <!--end::Wrapper-->

                                                <!--begin::Action-->
                                                <div class="m-0">
                                                    <!--begin::Menu-->
                                                    <button
                                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                        data-kt-menu-overflow="true">

                                                        <i class="ki-duotone ki-dots-square fs-1"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span></i>
                                                    </button>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                                        data-kt-menu="true" style="">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">
                                                                Quick Actions</div>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu separator-->
                                                        <div class="separator mb-3 opacity-75"></div>
                                                        <!--end::Menu separator-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Ticket
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Customer
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                            data-kt-menu-placement="right-start">
                                                            <!--begin::Menu item-->
                                                            <a href="#" class="menu-link px-3">
                                                                <span class="menu-title">New Group</span>
                                                                <span class="menu-arrow"></span>
                                                            </a>
                                                            <!--end::Menu item-->

                                                            <!--begin::Menu sub-->
                                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Admin Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Staff Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Member Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu sub-->
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Contact
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu separator-->
                                                        <div class="separator mt-3 opacity-75"></div>
                                                        <!--end::Menu separator-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content px-3 py-3">
                                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                                    Generate Reports
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>

                                                    <!--begin::Menu 2-->

                                                    <!--end::Menu 2-->

                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::Action-->
                                            </div>
                                            <!--end::Info-->

                                            <!--begin::Customer-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Name-->
                                                <span class="text-gray-400 fw-bold">To:
                                                    <a href="../apps/ecommerce/sales/details.html"
                                                        class="text-gray-800 text-hover-primary fw-bold">
                                                        Jason Bourne </a>
                                                </span>
                                                <!--end::Name-->

                                                <!--begin::Label-->
                                                <span class="badge badge-light-success">Delivered</span>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Customer-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-line w-40px" style="border-left-color: var(--bs-gray-400);"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px">
                                    <div class="symbol-label" style="background-color: var(--bs-gray-200) !important;">
                                        <i class="ki-duotone ki-check fs-2"></i>
                                    </div>
                                </div>
                                <div class="timeline-content">
                                    <div class="pb-5 pe-3">
                                        <div class="border border-dashed border-gray-300 rounded px-7 py-3">
                                            <!--begin::Info-->
                                            <div class="d-flex flex-stack mb-3">
                                                <!--begin::Wrapper-->
                                                <div class="me-3">
                                                    <!--begin::Icon-->
                                                    <img src="../assets/media/stock/ecommerce/210.gif"
                                                        class="w-50px ms-n1 me-1" alt="">
                                                    <!--end::Icon-->

                                                    <!--begin::Title-->
                                                    <a href="../apps/ecommerce/catalog/edit-product.html"
                                                        class="text-gray-800 text-hover-primary fw-bold">Elephant
                                                        1802</a>
                                                    <!--end::Title-->
                                                </div>
                                                <!--end::Wrapper-->

                                                <!--begin::Action-->
                                                <div class="m-0">
                                                    <!--begin::Menu-->
                                                    <button
                                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                        data-kt-menu-overflow="true">

                                                        <i class="ki-duotone ki-dots-square fs-1"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span></i>
                                                    </button>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                                        data-kt-menu="true" style="">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">
                                                                Quick Actions</div>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu separator-->
                                                        <div class="separator mb-3 opacity-75"></div>
                                                        <!--end::Menu separator-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Ticket
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Customer
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                            data-kt-menu-placement="right-start">
                                                            <!--begin::Menu item-->
                                                            <a href="#" class="menu-link px-3">
                                                                <span class="menu-title">New Group</span>
                                                                <span class="menu-arrow"></span>
                                                            </a>
                                                            <!--end::Menu item-->

                                                            <!--begin::Menu sub-->
                                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Admin Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Staff Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        Member Group
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu sub-->
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                New Contact
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->

                                                        <!--begin::Menu separator-->
                                                        <div class="separator mt-3 opacity-75"></div>
                                                        <!--end::Menu separator-->

                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content px-3 py-3">
                                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                                    Generate Reports
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>

                                                    <!--begin::Menu 2-->

                                                    <!--end::Menu 2-->

                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::Action-->
                                            </div>
                                            <!--end::Info-->

                                            <!--begin::Customer-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Name-->
                                                <span class="text-gray-400 fw-bold">To:
                                                    <a href="../apps/ecommerce/sales/details.html"
                                                        class="text-gray-800 text-hover-primary fw-bold">
                                                        Jason Bourne </a>
                                                </span>
                                                <!--end::Name-->

                                                <!--begin::Label-->
                                                <span class="badge badge-light-success">Delivered</span>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Customer-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/transfer/history/index.js') }}"></script>
@endpush
