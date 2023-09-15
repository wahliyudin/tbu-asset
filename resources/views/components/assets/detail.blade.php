<div class="row">
    @if ($withQrCode)
        <div class="col-md-3 text-center">
            <div class="card" style="width: auto !important; display: inline-block;">
                <div class="card-body py-4 px-4">
                    {!! QrCode::size(200)->generate(route('asset-masters.show-scan', $asset->kode)) !!}
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
                            data-bs-toggle="tab" href="#leasing">
                            Leasing </a>
                    </li>
                    <li class="nav-item my-1">
                        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-5 nav-link px-3 px-lg-4 mx-1 "
                            data-bs-toggle="tab" href="#asuransi">
                            Asuransi </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="asset-detail" role="tabpanel">
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Kode</label>
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
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->activity ?? '-' }}</span>
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
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->kondisi ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Unit
                                        Code</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->unit?->kode ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Quantity</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->quantity . ' ' . $asset->uom?->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
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
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">HM</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->hm ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">PR
                                        Number</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->pr_number ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">PO
                                        Number</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->po_number ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">GR
                                        Number</label>
                                    <div class="col-lg-7">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $asset->gr_number ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
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
                    <div class="tab-pane fade" id="leasing" role="tabpanel">
                        <div class="row mb-5">
                            <div class="col-lg-6 mb-5">
                                <div class="row">
                                    <label class="col-lg-4 fw-semibold text-muted">Dealer</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->leasing?->dealer?->name ?? '-' }}</span>
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
                                    <label class="col-lg-4 fw-semibold text-muted">Legalitas</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->leasing?->legalitas ?? '-' }}</span>
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
                                    <label class="col-lg-4 fw-semibold text-muted">Legalitas</label>
                                    <div class="col-lg-7">
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $asset->insurance?->legalitas ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>