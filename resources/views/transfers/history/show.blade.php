@extends('layouts.master')


@section('title', 'Detail History')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Detail History
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('asset-transfers.histories.index') }}" class="text-muted text-hover-primary">
                            History </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Detail History</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="timeline">
                @foreach ($asset->transfers as $transfer)
                    <div class="timeline-item">
                        <div class="timeline-line w-40px" style="border-left-color: var(--bs-gray-400);"></div>
                        <div class="timeline-icon symbol symbol-circle symbol-40px">
                            <div class="symbol-label" style="background-color: var(--bs-gray-200) !important;">
                                <i class="ki-duotone ki-check fs-2"></i>
                            </div>
                        </div>
                        <div class="timeline-content mb-10 mt-n1">
                            <div class="pb-5 pe-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    {{ $transfer->new_location }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
