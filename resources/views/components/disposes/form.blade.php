<form action="" class="form-dispose">
    <input type="hidden" name="id" value="{{ $assetDispose?->id }}">
    <input type="hidden" name="no_dispose" value="{{ $assetDispose?->no_dispose }}">
    <input type="hidden" name="nik" value="{{ $assetDispose?->nik }}">
    <x-form-header title="PENGHAPUSAN ASSET" nomor="TBU-FM-AST-002" tanggal="12-04-2023" revisi="00"
        halaman="1 dari 1" />
    <hr>
    <div class="row">
        <div class="col-md-6">
            <table class="w-100">
                <tbody>
                    <tr>
                        <td class="fs-6 fw-semibold w-150px">Department</td>
                        <td>:</td>
                        <td>{{ $employee->position?->department?->department_name }}</td>
                    </tr>
                    <tr>
                        <td class="fs-6 fw-semibold w-150px">Project</td>
                        <td>:</td>
                        <td>{{ $employee->position?->project?->project }}</td>
                    </tr>
                    <tr>
                        <td class="fs-6 fw-semibold w-150px">Division</td>
                        <td>:</td>
                        <td>{{ $employee->position?->divisi->division_name }}</td>
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
                        <td>
                            {{ $employee->position?->project?->location }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fs-6 fw-semibold w-150px">Tanggal Pengajuan</td>
                        <td>:</td>
                        <td>
                            {{ isset($assetDispose?->created_at) ? $assetDispose?->created_at : now()->format('d-m-Y') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            @if ($type != 'show')
                <div class="row justify-content-between py-2">
                    <div class="col-md-4">
                        {{-- <input type="file" class="form-control"> --}}
                    </div>
                    <div class="col-md-8 text-end">
                        <button type="button" class="btn btn-sm btn-primary ps-3 btn-select-asset">
                            <i class="ki-duotone ki-search-list fs-2">
                                <i class="path1"></i>
                                <i class="path2"></i>
                                <i class="path3"></i>
                            </i>Pilih Asset</button>
                    </div>
                </div>
            @endif
            <table class="table table-bordered border-gray-300 table-asset-selected">
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
                        <td>
                            <input type="hidden" name="asset_id" value="{{ $assetDispose?->asset_id }}">
                            <input type="text" readonly name="description"
                                value="{{ $assetDispose?->asset?->unit?->spesification }}" class="form-control">
                        </td>
                        <td>
                            <input type="text" readonly name="model_spesification"
                                value="{{ $assetDispose?->asset?->unit?->model }}" class="form-control">
                        </td>
                        <td>
                            <input type="text" readonly name="serial_no"
                                value="{{ $assetDispose?->asset?->unit?->serial_number }}" class="form-control">
                        </td>
                        <td>
                            <input type="text" readonly name="no_asset" value="{{ $assetDispose?->asset?->kode }}"
                                class="form-control">
                        </td>
                        <td>
                            <input type="text" readonly name="tahun_buat"
                                value="{{ $assetDispose?->asset?->unit?->tahun_pembuatan }}" class="form-control">
                        </td>
                        <td>
                            <input type="text" readonly name="nilai_buku"
                                value="{{ \App\Helpers\Helper::formatRupiah($assetDispose?->nilai_buku) }}"
                                class="form-control uang">
                        </td>
                        <td>
                            <input type="text" name="est_harga_pasar" @readonly($type == 'show')
                                value="{{ \App\Helpers\Helper::formatRupiah($assetDispose?->est_harga_pasar) }}"
                                class="form-control uang">
                        </td>
                        <td>
                            <textarea name="remark" @readonly($type == 'show') rows="1" class="form-control">{{ $assetDispose?->remark }}</textarea>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="text-center bg-secondary bg-opacity-50">
                        <th colspan="8">Justifikasi / Alasan Dispose</th>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <textarea name="justifikasi" @readonly($type == 'show') class="form-control">{{ $assetDispose?->justifikasi }}</textarea>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row mt-8">
        <div class="col-md-12">
            <div class="d-flex">
                <h5>Cara Pelaksanaan Penghapusan Asset Yang Ditentukan :</h5>
                <x-disposes.pelaksanaan :type="$type" :assetDispose="$assetDispose" />
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
    @if ($type != 'show')
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
    @endif
    @if ($type == 'show' && $withWorkflow)
        <div class="row mt-8">
            <x-approval :workflows="$assetDispose->workflows" />
            <div class="col-md-12 d-flex justify-content-start mt-4">
                @permission('asset_dispose_approv')
                    <button {{ !$isCurrentWorkflow ? 'disabled' : '' }} type="button"
                        data-dispose="{{ $assetDispose?->id }}" class="btn btn-success ps-4 approv">
                        <span class="indicator-label">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-check-circle fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>Approval
                            </div>
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                @endpermission
                @permission('asset_dispose_reject')
                    <button {{ !$isCurrentWorkflow ? 'disabled' : '' }} type="button"
                        data-dispose="{{ $assetDispose?->id }}" class="btn btn-danger ms-2 ps-4 reject">
                        <span class="indicator-label">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-duotone ki-cross-circle fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>Reject
                            </div>
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                @endpermission
            </div>
        </div>
    @endif
</form>
@if ($type == 'show')
    @push('js')
        <script src="{{ asset('assets/js/pages/dispose/form.js') }}"></script>
    @endpush
@endif
