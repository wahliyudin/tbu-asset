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
                    name: 'no_dispose',
                    data: 'no_dispose',
                },
                {
                    name: 'pelaksanaan',
                    data: 'pelaksanaan',
                },
                {
                    name: 'nilai_buku',
                    data: 'nilai_buku',
                },
                {
                    name: 'est_harga_pasar',
                    data: 'est_harga_pasar',
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
