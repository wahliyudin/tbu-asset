@extends('layouts.master')

@section('title', 'Register Cer')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Register Cer
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('asset-requests.index') }}" class="text-muted text-hover-primary">
                            Cer </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Register Cer</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="" method="post" class="form-asset">
                <x-assets.form :units="$units" :subClusters="$subClusters" :employees="$employees" :dealers="$dealers" :leasings="$leasings" />
                <div class="d-flex justify-content-end">
                    <button type="button" data-cer="{{ $cer->id }}" class="btn btn-sm btn-primary ps-4 simpan">
                        <span class="indicator-label">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-save-2 fs-3">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>Simpan
                            </div>
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/custom/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/cer/register.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('input[name="kode"]').val('');
            $('select[name="unit_id"]').val('').trigger('change');
            $('select[name="sub_cluster_id"]').val('').trigger('change');
            $('select[name="pic"]').val('').trigger('change');
            $('input[name="activity"]').val('');
            $('input[name="asset_location"]').val('');
            $('input[name="kondisi"]').val('');
            $('input[name="uom"]').val('');
            $('input[name="quantity"]').val('');
            $('input[name="tgl_bast"]').val('');
            $('input[name="hm"]').val('');
            $('input[name="pr_number"]').val("{{ isset($cerTxis['prnumber']) ? $cerTxis['prnumber'] : '' }}");
            $('input[name="po_number"]').val("{{ isset($cerTxis['ponumber']) ? $cerTxis['ponumber'] : '' }}");
            $('input[name="gr_number"]').val("{{ isset($cerTxis['grnumber']) ? $cerTxis['grnumber'] : '' }}");
            $('input[name="remark"]').val('');
            $('select[name="status"]').val('').trigger('change');

            $('select[name="dealer_id_leasing"]').val('').trigger('change');
            $('select[name="leasing_id_leasing"]').val('').trigger('change');
            $('input[name="harga_beli_leasing"]').val('');
            $('input[name="jangka_waktu_leasing"]').val('');
            $('input[name="biaya_leasing"]').val('');
            $('input[name="legalitas_leasing"]').val('');

            $('input[name="jangka_waktu_insurance"]').val('');
            $('input[name="biaya_insurance"]').val('');
            $('input[name="legalitas_insurance"]').val('');
        });
    </script>
@endpush
