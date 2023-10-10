@extends('layouts.master')

@section('title', 'Dashboard')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Dashboard
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        Dashboard </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-xl-5">
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-5">
                <div class="card">
                    <div class="card-body">
                        <div id="kt_amcharts_3" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-5">
                <div class="card">
                    <div class="card-body">
                        <div id="pie-chart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5 g-xl-10 mb-xl-5">
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-5">
                <div class="card">
                    <div class="card-body">
                        <div id="bar-chart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-5">
                <div class="card">
                    <div class="card-body">
                        <div id="pie-chart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="user" value="{{ auth()->user()?->id }}">
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    @vite('resources/js/app.js')
    <script src="{{ asset('assets/js/pages/home/index.js') }}"></script>
@endpush
