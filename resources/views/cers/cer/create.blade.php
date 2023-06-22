@extends('layouts.master')

@section('title', 'Create Cer')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Cer
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('asset-requests.index') }}" class="text-muted text-hover-primary">
                            Cer </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Create Cer</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="" class="form-cer">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <img src="{{ asset('assets/media/logos/tbu.png') }}" style="width: 100%;" alt="">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column">
                            <h5 class="fw-bold text-center" style="text-transform: uppercase;">tbu
                                management
                                system</h5>
                            <h6 class="fw-bold text-center" style="text-transform: uppercase;">formulir <br>
                                CAPITAL EXPENDITURE REQUEST
                            </h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="py-0" style="font-size: 14px;">Nomor</td>
                                    <td class="py-0 px-2">:</td>
                                    <td class="py-0" style="font-size: 14px; white-space: nowrap;">
                                        TBU-FM-AST-001</td>
                                </tr>
                                <tr>
                                    <td class="py-0" style="font-size: 14px; white-space: nowrap;">Tanggal
                                        Terbit</td>
                                    <td class="py-0 px-2">:</td>
                                    <td class="py-0" style="font-size: 14px;">12-04-2023</td>
                                </tr>
                                <tr>
                                    <td class="py-0" style="font-size: 14px;">Revisi</td>
                                    <td class="py-0 px-2">:</td>
                                    <td class="py-0" style="font-size: 14px;">00</td>
                                </tr>
                                <tr>
                                    <td class="py-0" style="font-size: 14px;">Halaman</td>
                                    <td class="py-0 px-2">:</td>
                                    <td class="py-0" style="font-size: 14px;">1 dari 1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td class="fs-6 fw-semibold">Peruntukan</td>
                                    <td>:</td>
                                    <td>
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" name="peruntukan" type="radio" value=""
                                                id="penggantian" />
                                            <label class="form-check-label fs-6 fw-semibold" for="penggantian">
                                                Penggantian
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" name="peruntukan" type="radio" value=""
                                                id="penambahan" />
                                            <label class="form-check-label fs-6 fw-semibold" for="penambahan">
                                                Penambahan
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" name="peruntukan" type="radio" value=""
                                                id="safety" />
                                            <label class="form-check-label fs-6 fw-semibold" for="safety">
                                                Safety
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td class="fs-6 fw-semibold">Status</td>
                                    <td>:</td>
                                    <td>
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" name="status" type="radio" value=""
                                                id="budgeted" />
                                            <label class="form-check-label fs-6 fw-semibold" for="budgeted">
                                                Budgeted
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" name="status" type="radio" value=""
                                                id="nonbudgeted" />
                                            <label class="form-check-label fs-6 fw-semibold" for="nonbudgeted">
                                                Non Budgeted
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td class="fs-6 fw-semibold">Department</td>
                                    <td>:</td>
                                    <td>
                                        {{ $employee->position->department->department_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold">Project</td>
                                    <td>:</td>
                                    <td>
                                        {{ $employee->position->project->project }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold">Lokasi</td>
                                    <td>:</td>
                                    <td>
                                        {{ $employee->position->project->location }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td class="fs-6 fw-semibold">Tanggal Pengajuan</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" class="form-control date">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold">Tanggal Kebutuhan</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" class="form-control date">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex flex-column mt-4 me-4">
                    <div class="d-flex flex-column">
                        <h5>1. Justifikasi / alasan pengadaan</h5>
                        <textarea name="justifikasi" class="form-control ms-4"></textarea>
                    </div>
                    <div class="d-flex flex-column mt-4">
                        <h5>2. Items</h5>
                        <div class="table-responsive ms-4" style="margin-right: -10px;">
                            <table class="table table-bordered border-gray-300 items">
                                <thead>
                                    <tr class="fw-bold text-center bg-secondary bg-opacity-50">
                                        <th class="fs-6 fw-semibold w-200px">Asset Description</th>
                                        <th class="fs-6 fw-semibold w-200px">Asset Model</th>
                                        <th class="fs-6 fw-semibold w-200px">Est. Umur Asset</th>
                                        <th class="fs-6 fw-semibold w-100px">Asset Qty</th>
                                        <th class="fs-6 fw-semibold w-200px">Unit Price</th>
                                        <th class="fs-6 fw-semibold w-200px">Sub Total Price</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody data-repeater-list="items">
                                    <tr data-repeater-item>
                                        <td>
                                            <input type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" min="1" class="form-control">
                                                <span class="input-group-text">Bulan</span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" min="1" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" readonly class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" readonly class="form-control">
                                        </td>
                                        <td>
                                            <button type="button" data-repeater-delete
                                                class="btn btn-sm btn-danger ps-3 pe-2">
                                                <i class="ki-duotone ki-trash fs-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td>
                                            <button type="button" data-repeater-create
                                                class="btn btn-sm btn-info ps-3 pe-2">
                                                <i class="ki-duotone ki-plus fs-3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <h5>3. Harga Total (estimasi)</h5>
                        </div>
                        <div class="col-md-4 pe-0 ps-8">
                            <table class="table table-bordered border-gray-300 w-100">
                                <tbody>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">IDR</td>
                                        <td class="w-200px"></td>
                                    </tr>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">USD</td>
                                        <td class="w-200px"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <h5>4. Sumber Pendanaan</h5>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex align-items-center justify-content-evenly w-100">
                                <div class="form-check form-check-custom">
                                    <input class="form-check-input" name="sumber_pendanaan" type="radio"
                                        value="" id="leasing" />
                                    <label class="form-check-label fs-6 fw-semibold" for="leasing">
                                        Leasing
                                    </label>
                                </div>
                                <div class="form-check form-check-custom">
                                    <input class="form-check-input" name="sumber_pendanaan" type="radio"
                                        value="" id="bukanleasing" />
                                    <label class="form-check-label fs-6 fw-semibold" for="bukanleasing">
                                        Bukan Leasing
                                    </label>
                                </div>
                                <div class="form-check form-check-custom">
                                    <input class="form-check-input" name="sumber_pendanaan" type="radio"
                                        value="" id="transfer" />
                                    <label class="form-check-label fs-6 fw-semibold" for="transfer">
                                        Transfer Asset
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <h5>5. Badget</h5>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-bordered w-100 border-gray-300">
                                <tbody>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">Ref No</td>
                                        <td class="w-200px"></td>
                                    </tr>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">Periode (tahun)
                                        </td>
                                        <td class="w-200px"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 pe-0">
                            <table class="table table-bordered w-100 border-gray-300">
                                <tbody>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">IDR</td>
                                        <td class="w-200px"></td>
                                    </tr>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50">USD</td>
                                        <td class="w-200px"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex flex-column mt-4">
                        <h5>6. Cost & Benefit Analyst</h5>
                        <textarea name="justifikasi" class="form-control ms-4"></textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-primary simpan-form-cer">
                        <span class="indicator-label">
                            Simpan
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-center">
                        <div class="d-flex flex-column bg-success w-200px"
                            style="border-radius: 10px 0 0 10px; overflow: hidden;">
                            <div class="border text-center text-white p-1 d-flex flex-column">
                                <p class="m-0 fw-bold" style="font-size: 15px;">
                                    Title
                                    By
                                </p>
                                <p class="m-0">Nama Karyawan</p>
                            </div>
                            <div class="border text-center text-white p-1 d-flex flex-column">
                                <p class="m-0 fw-bold" style="font-size: 15px;">
                                    Title
                                    On
                                </p>
                                <p class="m-0">
                                    Tanggal
                                </p>
                            </div>
                        </div>
                        <div class="d-flex flex-column bg-success w-200px"
                            style="border-radius: 0 10px 10px 0; overflow: hidden;">
                            <div class="border text-center text-white p-1 d-flex flex-column">
                                <p class="m-0 fw-bold" style="font-size: 15px;">
                                    Title
                                    By
                                </p>
                                <p class="m-0">Nama Karyawan</p>
                            </div>
                            <div class="border text-center text-white p-1 d-flex flex-column">
                                <p class="m-0 fw-bold" style="font-size: 15px;">
                                    Title
                                    On
                                </p>
                                <p class="m-0">
                                    Tanggal
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".date").flatpickr();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.items').repeater({
                initEmpty: false,
                defaultValues: {
                    'text-input': 'foo'
                },
                show: function() {
                    $(this).slideDown();
                    $(this).find('[data-kt-repeater="select2"]').select2();
                },
                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
                ready: function() {
                    $(`.items [data-kt-repeater="select2"]`).select2();
                }
            });
            $(`.form-cer`).on('click', `.simpan-form-cer`, function(e) {
                e.preventDefault();
                var postData = new FormData($(`.form-cer`)[0]);
                $(`.simpan-form-cer`).attr("data-kt-indicator", "on");
                $.ajax({
                    type: 'POST',
                    url: "/settings/approval/store",
                    processData: false,
                    contentType: false,
                    data: postData,
                    success: function(response) {
                        $(`.simpan-form-cer`).removeAttr("data-kt-indicator");
                        Swal.fire(
                            'Success!',
                            response.message,
                            'success'
                        ).then(function() {
                            location.reload();
                        });
                    },
                    error: function(jqXHR, xhr, textStatus, errorThrow, exception) {
                        $(`.simpan-form-cer`).removeAttr("data-kt-indicator");
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
