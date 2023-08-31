@extends('layouts.master')

@section('title', 'Show Asset')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Show Asset
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('asset-masters.index') }}" class="text-muted text-hover-primary">
                            Asset </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Show Asset</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-flush mb-9" id="kt_user_profile_panel">
        <!--begin::Hero nav-->
        <div class="card-header rounded-top bgi-size-cover h-200px"
            style="background-position: 100% 50%; background-image:url('{{ asset('assets/media/misc/profile-head-bg.jpg') }}')">
        </div>
        <!--end::Hero nav-->

        <!--begin::Body-->
        <div class="card-body mt-n19">
            <!--begin::Details-->
            <div class="m-0">
                <!--begin: Pic-->
                <div class="d-flex flex-stack align-items-end pb-4 mt-n19">
                    <div class="symbol symbol-150px symbol-lg-200px symbol-fixed position-relative mt-n3">
                        <img src="{{ asset('assets/media/avatars/300-3.jpg') }}" alt="image"
                            class="border border-white border-4" style="border-radius: 20px">
                        <div
                            class="position-absolute translate-middle bottom-0 start-100 ms-n1 mb-9 bg-success rounded-circle h-15px w-15px">
                        </div>
                    </div>
                </div>
                <!--end::Pic-->
            </div>
            <!--end::Details-->
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Profile Details</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9">
                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">Max Smith</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Company</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <span class="fw-semibold text-gray-800 fs-6">Keenthemes</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">
                            Contact Phone

                            <span class="ms-1" data-bs-toggle="tooltip" aria-label="Phone number must be active"
                                data-bs-original-title="Phone number must be active" data-kt-initialized="1">
                                <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i> </span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <span class="fw-bold fs-6 text-gray-800 me-2">044 3276 454 935</span>
                            <span class="badge badge-success">Verified</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Company Site</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">keenthemes.com</a>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">
                            Country

                            <span class="ms-1" data-bs-toggle="tooltip" aria-label="Country of origination"
                                data-bs-original-title="Country of origination" data-kt-initialized="1">
                                <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i> </span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">Germany</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Communication</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">Email, Phone</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-10">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Allow Changes</label>
                        <!--begin::Label-->

                        <!--begin::Label-->
                        <div class="col-lg-8">
                            <span class="fw-semibold fs-6 text-gray-800">Yes</span>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->

                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
@endsection
