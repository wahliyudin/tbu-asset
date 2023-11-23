"use strict";

var index = function () {
    var datatable;

    var initDatatable = function () {
        datatable = $('#asset_request_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: `/reports/asset-requests/datatable`,
                data: function (data) {
                    data.status = $('select[name="status"]').val();
                }
            },
            columns: [
                {
                    name: 'no_cer',
                    data: 'no_cer',
                },
                {
                    name: 'employee',
                    data: 'employee',
                },
                {
                    name: 'type_budget',
                    data: 'type_budget',
                },
                {
                    name: 'department',
                    data: 'department',
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
                    name: 'justifikasi',
                    data: 'justifikasi',
                },
                {
                    name: 'sumber_pendanaan',
                    data: 'sumber_pendanaan',
                },
                {
                    name: 'cost_analyst',
                    data: 'cost_analyst',
                },
                {
                    name: 'note',
                    data: 'note',
                },
                {
                    name: 'file_ucr',
                    data: 'file_ucr',
                },
                {
                    name: 'status_pr',
                    data: 'status_pr',
                },
                {
                    name: 'status',
                    data: 'status',
                },
            ],
        });
    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-asset-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    var handleEvents = () => {
        $('#filter-asset_request_submit').click(function (e) {
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
                url: "/reports/asset-requests/export",
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
