@extends('layouts.master')

@section('title', 'Register Asset')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Register Asset
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('asset-registers.index') }}" class="text-muted text-hover-primary">Register Asset
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Register Asset</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="" method="post" class="form-asset">
                <x-assets.form :units="$units" :subClusters="$subClusters" :employees="$employees" :dealers="$dealers" :leasings="$leasings"
                    :projects="$projects" :uoms="$uoms" />
                <div class="d-flex justify-content-end">
                    <button type="button" data-cer-item="{{ $cerItem->id }}" class="btn btn-sm btn-primary ps-4 simpan">
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
    <script src="{{ asset('assets/js/pages/cer/register/register.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('input[name="kode"]').val("{{ $kode }}");
            $('select[name="unit_id"]').val('').trigger('change');
            $('select[name="sub_cluster_id"]').val('').trigger('change');
            $('select[name="pic"]').val('{{ $cerItem->cer?->nik }}').trigger('change');
            $('input[name="activity"]').val('');
            $('select[name="asset_location"]').val(
                "{{ $cerItem->cer?->employee?->position?->project?->project_id }}").trigger('change');
            $('input[name="kondisi"]').val('');
            $('select[name="uom_id"]').val("{{ $cerItem->uom_id }}").trigger('change');
            $('input[name="quantity"]').val("{{ $cerItem->qty }}");
            $('input[name="tgl_bast"]').val(
                "{{ isset($cerItemDetail['gr']['tgl_bast']) ? $cerItemDetail['gr']['tgl_bast'] : '' }}");
            $('input[name="hm"]').val('');
            $('input[name="pr_number"]').val(
                "{{ isset($cerItemDetail['pr']['pr']) ? $cerItemDetail['pr']['pr'] : '' }}");
            $('input[name="po_number"]').val(
                "{{ isset($cerItemDetail['po']['po']) ? $cerItemDetail['po']['po'] : '' }}");
            $('input[name="gr_number"]').val(
                "{{ isset($cerItemDetail['gr']['gr']) ? $cerItemDetail['gr']['gr'] : '' }}");
            $('input[name="remark"]').val('');
            $('select[name="status"]').val('{{ \App\Enums\Asset\Status::ACTIVE->value }}').trigger('change');

            $('select[name="dealer_id_leasing"]').val(
                    "{{ isset($cerItemDetail['po']['vendorid']) ? $cerItemDetail['po']['vendorid'] : '' }}")
                .trigger('change');
            $('select[name="leasing_id_leasing"]').val('').trigger('change');
            $('input[name="harga_beli_leasing"]').val("{{ $cerItem->price }}").trigger('input');
            $('input[name="jangka_waktu_leasing"]').val("");
            $('input[name="biaya_leasing"]').val('');
            $('input[name="legalitas_leasing"]').val('');

            $('input[name="jangka_waktu_insurance"]').val("");
            $('input[name="biaya_insurance"]').val('');
            $('input[name="legalitas_insurance"]').val('');
        });
    </script>
@endpush
