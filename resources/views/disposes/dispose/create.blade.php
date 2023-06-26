@extends('layouts.master')

@section('title', 'Create Asset Dispose')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Asset Dispose
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('asset-disposes.index') }}" class="text-muted text-hover-primary">
                            Asset Dispose </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Create Asset Dispose</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-disposes.form />
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(`.form-dispose`).on('click', `.simpan-form-dispose`, function(e) {
                e.preventDefault();
                var postData = new FormData($(`.form-dispose`)[0]);
                $(`.simpan-form-dispose`).attr("data-kt-indicator", "on");
                $.ajax({
                    type: 'POST',
                    url: "/settings/approval/store",
                    processData: false,
                    contentType: false,
                    data: postData,
                    success: function(response) {
                        $(`.simpan-form-dispose`).removeAttr("data-kt-indicator");
                        Swal.fire(
                            'Success!',
                            response.message,
                            'success'
                        ).then(function() {
                            location.reload();
                        });
                    },
                    error: function(jqXHR, xhr, textStatus, errorThrow, exception) {
                        $(`.simpan-form-dispose`).removeAttr("data-kt-indicator");
                        if (jqXHR.status == 422) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan!',
                                text: JSON.parse(jqXHR.responseText)
                                    .message,
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: jqXHR.responseText,
                            })
                        }
                    }
                });
            });
        });
    </script>
@endpush
