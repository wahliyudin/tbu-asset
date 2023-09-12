"use strict";

var index = function () {

    var initDatatable = () => {
        datatable = $('#cer_item_table').DataTable({
            processing: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: "/asset-registers/datatable",
            },
            columns: [
                {
                    name: 'no_cer',
                    data: 'no_cer',
                },
                {
                    name: 'description',
                    data: 'description',
                },
                {
                    name: 'model',
                    data: 'model',
                },
                {
                    name: 'est_umur',
                    data: 'est_umur',
                },
                {
                    name: 'qty',
                    data: 'qty',
                },
                {
                    name: 'price',
                    data: 'price',
                },
                {
                    name: 'action',
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });
        const filterSearch = document.querySelector('[data-kt-cer-item-table-filter="search"]');
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
            initDatatable();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    index.init();
});
