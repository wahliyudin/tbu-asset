<ul class="nav nav-tabs nav-line-tabs flex-wrap border-transparent bg-gray-200 px-4 py-2 rounded">
    <li class="nav-item my-1">
        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 active"
            data-bs-toggle="tab" href="#asset">
            Asset </a>
    </li>
    <li class="nav-item my-1">
        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 "
            data-bs-toggle="tab" href="#unit">
            Unit </a>
    </li>
    <li class="nav-item my-1">
        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 "
            data-bs-toggle="tab" href="#leasing">
            Leasing </a>
    </li>
    <li class="nav-item my-1">
        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 "
            data-bs-toggle="tab" href="#asuransi">
            Asuransi </a>
    </li>
    <li class="nav-item my-1">
        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 "
            data-bs-toggle="tab" href="#depresiasi">
            Depresiasi </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade show active" id="asset" role="tabpanel">
        <div class="card">
            <div class="card-body p-9">
                <div class="row">
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">ID Asset</label>
                        <input type="text" class="form-control" placeholder="Kode" name="kode" />
                    </div>
                    <div class="col-md-4 fv-row mb-7 sub-cluster">
                        <label class="required fs-6 fw-semibold mb-2">Sub Cluster</label>
                        <select class="form-select form-select" name="sub_cluster_id" data-control="select2"
                            data-placeholder="Sub Cluster" data-dropdown-parent=".sub-cluster">
                            <option></option>
                            @foreach ($subClusters as $subCluster)
                                <option value="{{ $subCluster->getKey() }}">{{ $subCluster->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7 pic">
                        <label class="required fs-6 fw-semibold mb-2">PIC</label>
                        <select class="form-select form-select" name="pic" data-control="select2"
                            data-placeholder="PIC" data-dropdown-parent=".pic">
                            <option></option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->nik }}">{{ $employee->nama_karyawan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7 activity">
                        <label class="required fs-6 fw-semibold mb-2">Activity</label>
                        <select class="form-select form-select" name="activity_id" data-control="select2"
                            data-placeholder="Activity" data-dropdown-parent=".activity">
                            <option></option>
                            @foreach ($activities as $activity)
                                <option value="{{ $activity->getKey() }}">{{ $activity->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7 asset_location">
                        <label class="required fs-6 fw-semibold mb-2">Asset Location</label>
                        <select class="form-select form-select" name="asset_location" data-control="select2"
                            data-placeholder="Asset Location" data-dropdown-parent=".asset_location">
                            <option></option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->project_id }}">{{ $project->project }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7 condition">
                        <label class="required fs-6 fw-semibold mb-2">Kondisi</label>
                        <select class="form-select form-select" name="condition_id" data-control="select2"
                            data-placeholder="Kondisi" data-dropdown-parent=".condition">
                            <option></option>
                            @foreach ($conditions as $condition)
                                <option value="{{ $condition->getKey() }}">{{ $condition->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7 uom">
                        <label class="required fs-6 fw-semibold mb-2">UOM</label>
                        <select class="form-select form-select" name="uom_id" data-control="select2"
                            data-placeholder="UOM" data-dropdown-parent=".uom">
                            <option></option>
                            @foreach ($uoms as $uom)
                                <option value="{{ $uom->getKey() }}">{{ $uom->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Quantity</label>
                        <input type="number" class="form-control" placeholder="Quantity" name="quantity" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Tanggal Bast</label>
                        <input class="form-control" placeholder="Tanggal Bast" name="tgl_bast" id="tgl_bast" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">HM</label>
                        <input type="text" class="form-control" placeholder="HM" name="hm" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">PR Number</label>
                        <input type="text" class="form-control" placeholder="PR Number" name="pr_number" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">PO Number</label>
                        <input type="text" class="form-control" placeholder="PO Number" name="po_number" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">GR Number</label>
                        <input type="text" class="form-control" placeholder="GR Number" name="gr_number" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Remark</label>
                        <input type="text" class="form-control" placeholder="Remark" name="remark" />
                    </div>
                    <div class="col-md-4 fv-row mb-7 status">
                        <label class="required fs-6 fw-semibold mb-2">Status</label>
                        <select class="form-select form-select" name="status" data-control="select2"
                            data-placeholder="Status" data-dropdown-parent=".status">
                            <option></option>
                            @foreach (\App\Enums\Asset\Status::cases() as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="unit" role="tabpanel">
        <div class="card">
            <div class="card-body p-9">
                <div class="row">
                    <div class="col-md-4 fv-row mb-7 unit">
                        <label class="required fs-6 fw-semibold mb-2">Unit Model</label>
                        <select class="form-select form-select" name="unit_unit_id" data-control="select2"
                            data-placeholder="Unit" data-dropdown-parent=".unit">
                            <option></option>
                            @foreach ($units as $unit)
                                <option data-prefix="{{ $unit->prefix }}" value="{{ $unit->getKey() }}">
                                    {{ $unit->model }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">ID Unit</label>
                        <input type="text" class="form-control" placeholder="ID Unit" name="unit_kode" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">ID Unit Owner</label>
                        <input type="text" class="form-control" placeholder="ID Unit Owner"
                            name="unit_unit_id_owner" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Type</label>
                        <input type="text" class="form-control" placeholder="Type" name="unit_type" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Seri</label>
                        <input type="text" class="form-control" placeholder="Seri" name="unit_seri" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Class</label>
                        <input type="text" class="form-control" placeholder="Class" name="unit_class" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Brand</label>
                        <input type="text" class="form-control" placeholder="Brand" name="unit_brand" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Serial Number</label>
                        <input type="text" class="form-control" placeholder="Serial Number"
                            name="unit_serial_number" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Spesification</label>
                        <input type="text" class="form-control" placeholder="Spesification"
                            name="unit_spesification" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Kelengkapan Tambahan</label>
                        <input type="text" class="form-control" placeholder="Kelengkapan Tambahan"
                            name="unit_kelengkapan_tambahan" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Tahun Pembuatan</label>
                        <input type="text" id="tahun_pembuatan" class="form-control"
                            placeholder="Tahun Pembuatan" name="unit_tahun_pembuatan" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="leasing" role="tabpanel">
        <div class="card">
            <div class="card-body p-9">
                <div class="row">
                    <div class="col-md-4 fv-row mb-7 dealer">
                        <label class="required fs-6 fw-semibold mb-2">Dealer</label>
                        <select class="form-select form-select" name="dealer_id_leasing" data-control="select2"
                            data-placeholder="Dealer" data-dropdown-parent=".dealer">
                            <option></option>
                            @foreach ($dealers as $dealer)
                                <option value="{{ $dealer->vendorid }}">{{ $dealer->vendorname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7 leasing">
                        <label class="required fs-6 fw-semibold mb-2">Leasing</label>
                        <select class="form-select form-select" name="leasing_id_leasing" data-control="select2"
                            data-placeholder="Leasing" data-dropdown-parent=".leasing">
                            <option></option>
                            @foreach ($leasings as $leasing)
                                <option value="{{ $leasing->getKey() }}">{{ $leasing->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Harga Beli</label>
                        <input type="text" class="form-control uang" placeholder="Harga Beli"
                            name="harga_beli_leasing" />
                    </div>
                    <div class="col-md-4 fv-row mb-7 jangka_waktu_leasing">
                        <label class="required fs-6 fw-semibold mb-2">Jangka Waktu</label>
                        <select class="form-select form-select" name="jangka_waktu_leasing" data-control="select2"
                            data-placeholder="Jangka Waktu" data-dropdown-parent=".jangka_waktu_leasing">
                            <option></option>
                            @foreach ($lifetimes as $lifetime)
                                <option value="{{ $lifetime->masa_pakai }}">{{ $lifetime->masa_pakai }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Biaya Leasing</label>
                        <input type="text" class="form-control uang" placeholder="Biaya Leasing"
                            name="biaya_leasing" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Nomor Kontrak</label>
                        <input type="text" class="form-control" placeholder="Nomor Kontrak"
                            name="legalitas_leasing" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Tanggal Perolehan</label>
                        <input class="form-control" placeholder="Tanggal Perolehan" name="tanggal_perolehan_leasing"
                            id="tanggal_perolehan_leasing" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class=" fs-6 fw-semibold mb-2">Tanggal Awal</label>
                        <input class="form-control" placeholder="Tanggal Awal" name="tanggal_awal_leasing"
                            id="tanggal_awal_leasing" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class=" fs-6 fw-semibold mb-2">Tanggal Akhir</label>
                        <input class="form-control" readonly placeholder="Tanggal Akhir" name="tanggal_akhir_leasing"
                            id="tanggal_akhir_leasing" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="asuransi" role="tabpanel">
        <div class="card">
            <div class="card-body p-9">
                <div class="row">
                    <div class="col-md-4 fv-row mb-7 jangka_waktu_insurance">
                        <label class="required fs-6 fw-semibold mb-2">Jangka Waktu</label>
                        <select class="form-select form-select" name="jangka_waktu_insurance" data-control="select2"
                            data-placeholder="Jangka Waktu" data-dropdown-parent=".jangka_waktu_insurance">
                            <option></option>
                            @foreach ($lifetimes as $lifetime)
                                <option value="{{ $lifetime->masa_pakai }}">{{ $lifetime->masa_pakai }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Biaya</label>
                        <input type="text" class="form-control uang" placeholder="Biaya"
                            name="biaya_insurance" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Nomor Asuransi</label>
                        <input type="text" class="form-control" placeholder="Nomor Asuransi"
                            name="legalitas_insurance" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class=" fs-6 fw-semibold mb-2">Tanggal Awal</label>
                        <input class="form-control" placeholder="Tanggal Awal" name="tanggal_awal_insurance"
                            id="tanggal_awal_insurance" />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class=" fs-6 fw-semibold mb-2">Tanggal Akhir</label>
                        <input class="form-control" readonly placeholder="Tanggal Akhir"
                            name="tanggal_akhir_insurance" id="tanggal_akhir_insurance" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="depresiasi" role="tabpanel">
        <div class="card">
            <div class="card-body p-9">
                <div class="row">
                    <div class="col-md-4 fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Harga Beli/ Nilai Perolehan</label>
                        <input type="text" class="form-control uang" placeholder="Nilai Perolehan" name="price"
                            readonly />
                    </div>
                    <div class="col-md-2 fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Tanggal BAST</label>
                        <input type="text" class="form-control" placeholder="Tanggal BAST" name="date"
                            readonly />
                    </div>
                    <div class="col-md-4 fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Nilai Sisa</label>
                        <input type="text" class="form-control uang" placeholder="Nilai Sisa" name="nilai_sisa"
                            value="0" />
                    </div>
                    <div class="col-md-2 fv-row mb-7 lifetime">
                        <label class="required fs-6 fw-semibold mb-2">Masa Pakai</label>
                        <select class="form-select form-select" name="lifetime_id" data-control="select2"
                            data-placeholder="Masa Pakai" data-dropdown-parent=".lifetime">
                            <option></option>
                            @foreach ($lifetimes as $lifetime)
                                <option value="{{ $lifetime->getKey() }}">{{ $lifetime->masa_pakai }}
                                </option>
                            @endforeach
                        </select>
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
@push('js')
    <script src="{{ asset('assets/js/pages/asset/form.js') }}"></script>
@endpush
