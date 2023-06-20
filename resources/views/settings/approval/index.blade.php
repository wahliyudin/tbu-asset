@extends('layouts.master')

@section('title', 'Approval')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Approval
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Setting</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Approval</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row gap-2 justify-content-center">
        @foreach ($settingApprovals as $settingApproval)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4 class="text-dark">Approval {{ $settingApproval['module'] }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" class="form-{{ $settingApproval['module'] }}"
                            id="{{ $settingApproval['module'] }}">
                            <input type="hidden" name="module" value="{{ $settingApproval['module'] }}">
                            <div class="form-group">
                                <div data-repeater-list="{{ $settingApproval['module'] }}" class="d-flex flex-column gap-3">
                                    @forelse ($settingApproval['childs'] as $child)
                                        @include('settings.approval.repeater.item-with-data')
                                    @empty
                                        @include('settings.approval.repeater.item')
                                    @endforelse
                                </div>
                            </div>
                            <div class="form-group mt-3 d-flex align-items-center justify-content-between">
                                <button type="button" data-repeater-create class="btn btn-sm btn-info text-white">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                    <span class="svg-icon svg-icon-2"><svg width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11" y="18" width="12" height="2"
                                                rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                            <rect x="6" y="11" width="12" height="2" rx="1"
                                                fill="currentColor" />
                                        </svg></span>
                                    <!--end::Svg Icon--> Add another approval
                                </button>
                                <button type="button" class="btn btn-primary simpan-{{ $settingApproval['module'] }}">
                                    <span class="indicator-label">
                                        Submit
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.each(@json($settingApprovals), function(index, feature) {
                var module = feature.module;
                var id = '#' + module;
                $(id).repeater({
                    initEmpty: false,
                    defaultValues: {
                        'text-input': 'foo'
                    },
                    show: function() {
                        $(this).slideDown();
                        $(this).find('[data-kt-repeater="select2"]').select2();
                        render(module);
                    },
                    hide: function(deleteElement) {
                        $(this).slideUp(deleteElement);
                    },
                    ready: function() {
                        $(`${id} [data-kt-repeater="select2"]`).select2();
                    }
                });
                render(module);

                $(`.form-${module}`).on('click', `.simpan-${module}`, function(e) {
                    e.preventDefault();
                    var postData = new FormData($(`.form-${module}`)[0]);
                    $(`.simpan-${module}`).attr("data-kt-indicator", "on");
                    $.ajax({
                        type: 'POST',
                        url: "/settings/approval/store",
                        processData: false,
                        contentType: false,
                        data: postData,
                        success: function(response) {
                            $(`.simpan-${module}`).removeAttr("data-kt-indicator");
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            ).then(function() {
                                location.reload();
                            });
                        },
                        error: function(jqXHR, xhr, textStatus, errorThrow, exception) {
                            $(`.simpan-${module}`).removeAttr("data-kt-indicator");
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

            function render(module) {
                $(`[data-repeater-list="${module}"] [data-repeater-item]`).each(function(index, element) {
                    $($(element).find(`select[name="${module}[${index}][approval]"]`)).on('change',
                        function() {
                            if ($(this).val() ==
                                "{{ \App\Enums\Settings\Approval::OTHER }}") {
                                $(element).find('.karyawan').show();
                            } else {
                                $(element).find('.karyawan').hide();
                            }
                        });
                });
            }
        });
    </script>
@endpush
