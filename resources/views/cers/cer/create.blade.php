@extends('layouts.master')

@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

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
                <x-form-header title="CAPITAL EXPENDITURE REQUEST" nomor="TBU-FM-AST-001" tanggal="12-04-2023"
                    revisi="00" halaman="1 dari 1" />
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
                                            <input class="form-check-input" checked name="peruntukan" type="radio"
                                                value="{{ \App\Enums\Cers\Peruntukan::PENGGANTIAN }}" id="penggantian" />
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
                                            <input class="form-check-input" name="peruntukan" type="radio"
                                                value="{{ \App\Enums\Cers\Peruntukan::PENAMBAHAN }}" id="penambahan" />
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
                                            <input class="form-check-input" name="peruntukan" type="radio"
                                                value="{{ \App\Enums\Cers\Peruntukan::SAFETY }}" id="safety" />
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
                                            <input class="form-check-input" checked name="type_budget" type="radio"
                                                value="{{ \App\Enums\Cers\TypeBudget::BUDGET }}" id="budgeted" />
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
                                            <input class="form-check-input" name="type_budget" type="radio"
                                                value="{{ \App\Enums\Cers\TypeBudget::UNBUDGET }}" id="nonbudgeted" />
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
                                    <td class="fs-6 fw-semibold w-150px">Department</td>
                                    <td>:</td>
                                    <td>
                                        {{ $employee->position->department->department_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold w-150px">Project</td>
                                    <td>:</td>
                                    <td>
                                        {{ $employee->position->project->project }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold w-150px">Lokasi</td>
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
                                        <input type="text" name="tanggal_pengajuan" disabled
                                            value="{{ now()->format('Y-m-d') }}" class="form-control date">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold">Tanggal Kebutuhan</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="tgl_kebutuhan" class="form-control date">
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
                        <div class="d-flex justify-content-end py-2">
                            <button type="button" class="btn btn-sm btn-primary ps-3 add-item"><i
                                    class="ki-duotone ki-plus fs-3"></i>Tambah</button>
                        </div>
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
                                            <input type="hidden" name="asset" class="asset">
                                            <input type="text" readonly name="asset_description"
                                                class="form-control asset-description">
                                        </td>
                                        <td>
                                            <input type="text" readonly name="asset_model"
                                                class="form-control asset-model">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" name="umur_asset" min="1"
                                                    class="form-control umur-asset">
                                                <span class="input-group-text">Bulan</span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" min="1" value="1"
                                                class="form-control qty">
                                        </td>
                                        <td>
                                            <input type="text" readonly class="form-control uang price">
                                        </td>
                                        <td>
                                            <input type="text" readonly class="form-control uang sub-total">
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
                                <tfoot style="display: none;">
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
                                        <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50"
                                            style="vertical-align: middle;">IDR</td>
                                        <td class="w-200px">
                                            <input type="text" readonly name="total_idr" class="form-control uang">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-200px bg-secondary bg-opacity-50"
                                            style="vertical-align: middle;">USD</td>
                                        <td class="w-200px">
                                            <input type="text" readonly name="total_usd" class="form-control uang">
                                        </td>
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
                                    <input class="form-check-input" checked name="sumber_pendanaan" type="radio"
                                        value="{{ \App\Enums\Cers\SumberPendanaan::LEASING }}" id="leasing" />
                                    <label class="form-check-label fs-6 fw-semibold" for="leasing">
                                        Leasing
                                    </label>
                                </div>
                                <div class="form-check form-check-custom">
                                    <input class="form-check-input" name="sumber_pendanaan" type="radio"
                                        value="{{ \App\Enums\Cers\SumberPendanaan::BUKAN_LEASING }}" id="bukanleasing" />
                                    <label class="form-check-label fs-6 fw-semibold" for="bukanleasing">
                                        Bukan Leasing
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4 d-flex justify-content-between align-items-start">
                            <h5>5. Badget</h5>
                            <button type="button" class="btn btn-sm btn-primary ps-3 pe-2 search-budget">
                                <i class="ki-duotone ki-search-list fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                </i>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-bordered w-100 border-gray-300">
                                <tbody>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">Ref No</td>
                                        <td class="w-250px">
                                            <input type="text" class="form-control" readonly name="budget_ref">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">Periode (tahun)
                                        </td>
                                        <td class="w-250px"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 pe-0">
                            <table class="table table-bordered w-100 border-gray-300">
                                <tbody>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">IDR</td>
                                        <td class="w-250px"></td>
                                    </tr>
                                    <tr>
                                        <td class="fs-6 fw-semibold w-150px bg-secondary bg-opacity-50">USD
                                        </td>
                                        <td class="w-250px"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex flex-column mt-4">
                        <h5>6. Cost & Benefit Analyst</h5>
                        <textarea name="cost_analyst" class="form-control ms-4"></textarea>
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

@push('modal')
    @include('cers.cer.modals.data-asset')
    @include('cers.cer.modals.data-budget')
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/cer/create.js') }}"></script>
@endpush
