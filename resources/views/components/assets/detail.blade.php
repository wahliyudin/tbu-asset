<div class="row">
    @if ($withQrCode)
        <div class="col-md-3 text-center mb-5">
            <div class="card" style="width: auto !important; display: inline-block;">
                <div class="card-body py-4 px-4">
                    {!! QrCode::size(200)->generate(route('asset-masters.show-scan', $asset->kode)) !!}
                    <table class="mt-1 text-start">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Project</td>
                                <td class="fw-bold">:</td>
                                <td>{{ $asset?->project?->project }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Id Asset</td>
                                <td class="fw-bold">:</td>
                                <td>{{ $asset?->kode }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-0">
                <ul
                    class="nav nav-tabs nav-line-tabs flex-wrap align-items-center w-100 border-transparent bg-gray-200 px-4 py-2 rounded">
                    <li class="nav-item my-1">
                        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-5 nav-link px-3 px-lg-4 mx-1 active"
                            data-bs-toggle="tab" href="#asset-detail">
                            Asset Details </a>
                    </li>
                    <li class="nav-item my-1">
                        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-5 nav-link px-3 px-lg-4 mx-1 "
                            data-bs-toggle="tab" href="#unit">
                            Unit </a>
                    </li>
                    <li class="nav-item my-1">
                        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-5 nav-link px-3 px-lg-4 mx-1 "
                            data-bs-toggle="tab" href="#leasing">
                            Leasing </a>
                    </li>
                    <li class="nav-item my-1">
                        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-5 nav-link px-3 px-lg-4 mx-1 "
                            data-bs-toggle="tab" href="#asuransi">
                            Asuransi </a>
                    </li>
                    <li class="nav-item my-1">
                        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-5 nav-link px-3 px-lg-4 mx-1 "
                            data-bs-toggle="tab" href="#depresiasi">
                            Depresiasi </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="asset-detail" role="tabpanel">
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">ID Asset</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->kode ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Status</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{!! $asset->status?->badge() ?? '-' !!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Sub
                                        Cluster</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->sub_cluster->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">PIC</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->employee->nama_karyawan ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Activity</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->activity?->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Asset
                                        Location</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->project?->project ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Kondisi</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->condition?->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Quantity</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->quantity . ' ' . $asset->uom?->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Tanggal
                                        Bast</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ \App\Helpers\CarbonHelper::convertDate($asset->tgl_bast, 'd F Y') ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">HM</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->hm ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">PR
                                        Number</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->pr_number ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">PO
                                        Number</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->po_number ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">GR
                                        Number</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->gr_number ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Umur Asset</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $umurAsset ?? '-' }} Bulan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Umur Pakai</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $umurPakai ?? '-' }} Bulan</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Remark</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->remark ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="unit" role="tabpanel">
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Unit Model</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->asset_unit?->unit?->model ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">ID Unit</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->asset_unit?->kode ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Type</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->asset_unit?->type ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Seri</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->asset_unit?->seri ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Class</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->asset_unit->class ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Brand</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->asset_unit?->brand ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Serial Number</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->asset_unit?->serial_number ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Spesification</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->asset_unit?->spesification ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Tahun Pembuatan</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->asset_unit?->tahun_pembuatan ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Kelengkapan Tambahan</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->asset_unit?->kelengkapan_tambahan ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="leasing" role="tabpanel">
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Dealer</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->leasing?->dealer?->vendorname ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Leasing</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->leasing?->leasing?->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Harga
                                        Beli</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ \App\Helpers\Helper::formatRupiah($asset->leasing?->harga_beli, true) ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Jangka
                                        Waktu</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ ($asset->leasing?->jangka_waktu_leasing ?? '-') . ' Bulan' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Biaya</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ \App\Helpers\Helper::formatRupiah($asset->leasing?->biaya_leasing, true) ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Nomor Kontrak</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->leasing?->legalitas ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Tanggal Awal</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ \App\Helpers\CarbonHelper::convertDate($asset->leasing?->tanggal_awal_leasing, 'd F Y') ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Tanggal Akhir</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ \App\Helpers\CarbonHelper::convertDate($asset->leasing?->tanggal_akhir_leasing, 'd F Y') ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Tanggal Perolehan</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ \App\Helpers\CarbonHelper::convertDate($asset->leasing?->tanggal_perolehan, 'd F Y') ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="asuransi" role="tabpanel">
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Jangka
                                        Waktu</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ ($asset->insurance?->jangka_waktu ?? '-') . ' Bulan' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Biaya</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ \App\Helpers\Helper::formatRupiah($asset->insurance?->biaya, true) ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Nomor Asuransi</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->insurance?->legalitas ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="depresiasi" role="tabpanel">
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Harga Beli/ Nilai Perolehan</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ \App\Helpers\Helper::formatRupiah($asset->leasing?->harga_beli) ?? '-' }}</span>
                                    </div>
                                    <input type="hidden" name="price"
                                        value="{{ \App\Helpers\Helper::formatRupiah($asset->leasing?->harga_beli) }}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Tanggal BAST</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ \App\Helpers\CarbonHelper::convertDate($asset->tgl_bast, 'd F Y') ?? '-' }}</span>
                                    </div>
                                    <input type="hidden" name="date"
                                        value="{{ \App\Helpers\CarbonHelper::convertDate($asset->tgl_bast) }}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Nilai Sisa</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ \App\Helpers\Helper::formatRupiah($asset->nilai_sisa) ?? '-' }}</span>
                                    </div>
                                    <input type="hidden" name="nilai_sisa"
                                        value="{{ \App\Helpers\Helper::formatRupiah($asset->nilai_sisa) }}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Masa Pakai</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->lifetime?->masa_pakai ?? '-' }}</span>
                                    </div>
                                    <input type="hidden" name="lifetime_id" value="{{ $asset->lifetime_id }}">
                                </div>
                            </div>
                        </div>
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="depresiasi_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Depresiasi</th>
                                    <th>Nilai Sisa</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600 depresiasi-container">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{ asset('assets/js/pages/asset/detail.js') }}"></script>
@endpush
