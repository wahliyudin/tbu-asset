"use strict";

var list = function () {
    var datatable;
    var table;

    var initList = function () {
        const tableRows = table.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
            const realDate = moment(dateRow[5].innerHTML, "DD MMM YYYY, LT").format(); // select date from 5th column in table
            dateRow[5].setAttribute('data-order', realDate);
        });
        datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: "/approvals/transfers/datatable"
            },
            columns: [
                {
                    name: 'no_transaksi',
                    data: 'no_transaksi',
                },
                {
                    name: 'asset',
                    data: 'asset',
                },
                {
                    name: 'old_pic',
                    data: 'old_pic',
                },
                {
                    name: 'new_pic',
                    data: 'new_pic',
                },
                {
                    name: 'status_transfer',
                    data: 'status_transfer',
                },
                {
                    name: 'status',
                    data: 'status',
                },
                {
                    name: 'action',
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        datatable.on('draw', function () {
        });
    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-approval-transfer-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            table = document.querySelector('#approval_transfer_table');
            if (!table) {
                return;
            }
            initList();
            handleSearchDatatable();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    list.init();
});
