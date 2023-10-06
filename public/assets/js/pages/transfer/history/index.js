"use strict";

var historyTransfer = function () {
    var datatable;
    var table;

    var initDatatable = function () {
        datatable = $('#history_transfer_table').DataTable({
            processing: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: "/asset-transfers/histories/datatable"
            },
            columns: [
                {
                    name: 'id_asset',
                    data: 'id_asset',
                },
                {
                    name: 'model',
                    data: 'model',
                },
                {
                    name: 'type',
                    data: 'type',
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
        const filterSearch = document.querySelector('[data-kt-history-transfer-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    var handleError = function (jqXHR) {
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
    };

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            initDatatable();
            handleSearchDatatable();
            $('#timeline').modal('show');
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    historyTransfer.init();
});
