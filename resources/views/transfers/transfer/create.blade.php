@extends('layouts.master')

@section('title', 'Create Asset Transfer')

@push('css')
    <style>
        ol.bracket {
            counter-reset: list;
        }

        ol.bracket>li {
            list-style: none;
        }

        ol.bracket>li:before {
            content: counter(list) ") ";
            counter-increment: list;
            font-size: 1rem !important;
        }
    </style>
@endpush

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Asset Transfer
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('asset-transfers.index') }}" class="text-muted text-hover-primary">
                            Asset Transfer </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Create Asset Transfer</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-transfers.form />
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(`.form-transfer`).on('click', `.simpan-form-transfer`, function(e) {
                e.preventDefault();
                var postData = new FormData($(`.form-transfer`)[0]);
                $(`.simpan-form-transfer`).attr("data-kt-indicator", "on");
                $.ajax({
                    type: 'POST',
                    url: "/settings/approval/store",
                    processData: false,
                    contentType: false,
                    data: postData,
                    success: function(response) {
                        $(`.simpan-form-transfer`).removeAttr("data-kt-indicator");
                        Swal.fire(
                            'Success!',
                            response.message,
                            'success'
                        ).then(function() {
                            location.reload();
                        });
                    },
                    error: function(jqXHR, xhr, textStatus, errorThrow, exception) {
                        $(`.simpan-form-transfer`).removeAttr("data-kt-indicator");
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
