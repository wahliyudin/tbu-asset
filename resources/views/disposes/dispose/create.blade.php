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
            <form action="" class="form-dispose">
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
                                PENGHAPUSAN ASSET
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
                                        TBU-FM-AST-002</td>
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
                                    <td class="fs-6 fw-semibold w-150px">Department</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold w-150px">Project</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold w-150px">Division</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td class="fs-6 fw-semibold w-150px">Lokasi</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-semibold w-150px">Tanggal Pengajuan</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <table class="table table-bordered border-gray-300">
                            <thead>
                                <tr class="text-center bg-secondary bg-opacity-50">
                                    <th>Deskripsi Asset</th>
                                    <th>Model & Spesifikasi</th>
                                    <th>Serial No. / Chasis No.</th>
                                    <th>Nomor Asset</th>
                                    <th>Tahun Buat / Beli</th>
                                    <th>Nilai Buku</th>
                                    <th>Estimasi Harga Pasar</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="text-center bg-secondary bg-opacity-50">
                                    <th colspan="8">Justifikasi / Alasan Dispose</th>
                                </tr>
                                <tr>
                                    <td colspan="8">
                                        <textarea name="justifikasi" class="form-control"></textarea>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
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
                <div class="row mt-8">
                    <div class="col-md-12">
                        <div class="d-flex">
                            <h5>Cara Pelaksanaan Penghapusan Asset Yang Ditentukan :</h5>
                            <div class="d-flex flex-grow-1 align-items-center justify-content-evenly">
                                <div class="form-check form-check-custom">
                                    <input class="form-check-input" name="pelaksanaan" type="radio" value=""
                                        id="penjualan" />
                                    <label class="form-check-label fs-6 fw-semibold" for="penjualan">
                                        Penjualan
                                    </label>
                                </div>
                                <div class="form-check form-check-custom">
                                    <input class="form-check-input" name="pelaksanaan" type="radio" value=""
                                        id="donasi" />
                                    <label class="form-check-label fs-6 fw-semibold" for="donasi">
                                        Donasi
                                    </label>
                                </div>
                                <div class="form-check form-check-custom">
                                    <input class="form-check-input" name="pelaksanaan" type="radio" value=""
                                        id="pemusnahan" />
                                    <label class="form-check-label fs-6 fw-semibold" for="pemusnahan">
                                        Pemusnahan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <h5>Keterangan :</h5>
                            <ol style="font-style: italic;">
                                <li>Setelah mendapatkan persetujuan penuh, beri tanda "X" pada kotak (a), (b) atau (c) atas
                                    pengurangan asset yang dimaksud:</li>
                                <ol type='a'>
                                    <li><span class="fw-bold">Penjualan</span>, bila pengurangan asset tersebut dengan
                                        jalan dijual</li>
                                    <li><span class="fw-bold">Donasi</span>, bila pengurangan asset dengan tujuan
                                        kemanusiaan, pendidikan atau tujuan sosial lainnya</li>
                                    <li><span class="fw-bold">Pemusnahan</span>, bila asset tersebut tidak memiliki nilai
                                        ekonomis atau tidak dapat dijual kembali</li>
                                </ol>
                                <li>Sertakan foto-foto atas asset yang akan di-dispose.</li>
                                <li>Penawaran dari calon pembeli (jika pilihan a) harus dilampirkankan untuk mendapatkan
                                    persetujuan.</li>
                                <li>Proposal penghapusan asset harus dibuat setelah form ini disetujui.</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-primary simpan-form-dispose">
                        <span class="indicator-label">
                            Simpan
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
