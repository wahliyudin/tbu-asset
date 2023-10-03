"use strict";

var index = function () {
    var datatable;

    var initDatatable = function () {
        datatable = $('#asset_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: `/reports/asset-masters/datatable`,
                data: function (data) {
                    data.status = $('select[name="status"]').val();
                    data.project = $('select[name="project"]').val();
                    data.category = $('select[name="category"]').val();
                    data.cluster = $('select[name="cluster"]').val();
                    data.sub_cluster = $('select[name="sub_cluster"]').val();
                }
            },
            columns: [
                {
                    name: 'kode',
                    data: 'kode',
                },
                {
                    name: 'unit_kode',
                    data: 'unit_kode',
                },
                {
                    name: 'unit_type',
                    data: 'unit_type',
                },
                {
                    name: 'unit_seri',
                    data: 'unit_seri',
                },
                {
                    name: 'unit_class',
                    data: 'unit_class',
                },
                {
                    name: 'unit_brand',
                    data: 'unit_brand',
                },
                {
                    name: 'unit_serial_number',
                    data: 'unit_serial_number',
                },
                {
                    name: 'unit_spesification',
                    data: 'unit_spesification',
                },
                {
                    name: 'unit_tahun_pembuatan',
                    data: 'unit_tahun_pembuatan',
                },
                {
                    name: 'unit_kelengkapan_tambahan',
                    data: 'unit_kelengkapan_tambahan',
                },
                {
                    name: 'category',
                    data: 'category',
                },
                {
                    name: 'cluster',
                    data: 'cluster',
                },
                {
                    name: 'sub_cluster',
                    data: 'sub_cluster',
                },
                {
                    name: 'pic',
                    data: 'pic',
                },
                {
                    name: 'activity',
                    data: 'activity',
                },
                {
                    name: 'asset_location',
                    data: 'asset_location',
                },
                {
                    name: 'department',
                    data: 'department',
                },
                {
                    name: 'condition',
                    data: 'condition',
                },
                {
                    name: 'uom',
                    data: 'uom',
                },
                {
                    name: 'quantity',
                    data: 'quantity',
                },
                {
                    name: 'masa_pakai',
                    data: 'masa_pakai',
                },
                {
                    name: 'nilai_sisa',
                    data: 'nilai_sisa',
                },
                {
                    name: 'tanggal_bast',
                    data: 'tanggal_bast',
                },
                {
                    name: 'hm',
                    data: 'hm',
                },
                {
                    name: 'pr_number',
                    data: 'pr_number',
                },
                {
                    name: 'po_number',
                    data: 'po_number',
                },
                {
                    name: 'pr_number',
                    data: 'pr_number',
                },
                {
                    name: 'status_asset',
                    data: 'status_asset',
                },
                {
                    name: 'status',
                    data: 'status',
                },
                {
                    name: 'remark',
                    data: 'remark',
                },
            ],
        });
    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-asset-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            // datatable.ajax.reload();
            datatable.search(e.target.value).draw();
        });
    }

    var handleEvents = () => {
        $('#filter-asset_submit').click(function (e) {
            e.preventDefault();
            datatable.ajax.reload();
            $('#filter-asset').modal('hide');
        });

        $('.export').click(function (e) {
            e.preventDefault();
            var postData = new FormData($(`.filter`)[0]);
            var target = this;
            $(target).attr("data-kt-indicator", "on");
            $.ajax({
                type: 'POST',
                url: "/reports/asset-masters/export",
                processData: false,
                contentType: false,
                data: postData,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function (data) {
                    $(target).removeAttr("data-kt-indicator");
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = 'assets.xlsx';
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                },
                error: function (jqXHR, xhr, textStatus, errorThrow, exception) {
                    $(target).removeAttr("data-kt-indicator");
                }
            });
        });
    }

    var handleError = function (jqXHR) {
        submitButton.removeAttribute('data-kt-indicator');
        submitButton.disabled = false;
        if (jqXHR.status == 422) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: JSON.parse(jqXHR.responseText).message,
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: jqXHR.responseText,
            })
        }
    }

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            initDatatable();
            handleSearchDatatable();
            handleEvents();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    index.init();
});
