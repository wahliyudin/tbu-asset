"use strict";

var list = function () {
    var datatable;

    var initDatatable = function () {
        datatable = $('#asset_idle_table').DataTable({
            processing: true,
            // serverSide: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: "/asset-idles/datatable",
                // data: function (d) {
                //     d.search = $('input[name="search"]').val();
                // }
            },
            columns: [
                {
                    name: 'kode',
                    data: 'kode',
                },
                {
                    name: 'kode_unit',
                    data: 'kode_unit',
                },
                {
                    name: 'unit_model',
                    data: 'unit_model',
                },
                {
                    name: 'unit_type',
                    data: 'unit_type',
                },
                {
                    name: 'asset_location',
                    data: 'asset_location',
                },
                {
                    name: 'pic',
                    data: 'pic',
                },
                {
                    name: 'action',
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });
    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-asset-idle-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            datatable.search(e.target.value).draw();
            // datatable.ajax.reload();
        });
    }

    var handleError = function (jqXHR, target) {
        $(target).removeAttr("data-kt-indicator");
        if (target) {
            target.disabled = false;
        }
        if (jqXHR.status == 422 || jqXHR.responseJSON.message.includes("404")) {
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
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    list.init();
});
