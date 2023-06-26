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
                url: "/approvals/disposes/datatable"
            },
            columns: [
                {
                    name: 'type_budget',
                    data: 'type_budget',
                },
                {
                    name: 'budget_ref',
                    data: 'budget_ref',
                },
                {
                    name: 'peruntukan',
                    data: 'peruntukan',
                },
                {
                    name: 'tgl_kebutuhan',
                    data: 'tgl_kebutuhan',
                },
                {
                    name: 'sumber_pendanaan',
                    data: 'sumber_pendanaan',
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
        const filterSearch = document.querySelector('[data-kt-approval-dispose-table-filter="search"]');
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
            table = document.querySelector('#approval_dispose_table');
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
