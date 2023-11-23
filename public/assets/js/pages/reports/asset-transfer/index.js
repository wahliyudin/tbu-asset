"use strict";

var index = function () {
    var datatable;

    var initDatatable = function () {
        datatable = $('#asset_transfer_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: `/reports/asset-transfers/datatable`,
                data: function (data) {
                    data.status = $('select[name="status"]').val();
                    data.old_project = $('select[name="old_project"]').val();
                    data.old_pic = $('select[name="old_pic"]').val();
                    data.new_project = $('select[name="new_project"]').val();
                    data.new_pic = $('select[name="new_pic"]').val();
                }
            },
            columns: [
                {
                    name: 'no_transaksi',
                    data: 'no_transaksi',
                },
                {
                    name: 'employee',
                    data: 'employee',
                },
                {
                    name: 'asset_id',
                    data: 'asset_id',
                },
                {
                    name: 'old_project',
                    data: 'old_project',
                },
                {
                    name: 'old_pic',
                    data: 'old_pic',
                },
                {
                    name: 'old_location',
                    data: 'old_location',
                },
                {
                    name: 'old_divisi',
                    data: 'old_divisi',
                },
                {
                    name: 'old_department',
                    data: 'old_department',
                },
                {
                    name: 'new_project',
                    data: 'new_project',
                },
                {
                    name: 'new_pic',
                    data: 'new_pic',
                },
                {
                    name: 'new_location',
                    data: 'new_location',
                },
                {
                    name: 'new_divisi',
                    data: 'new_divisi',
                },
                {
                    name: 'new_department',
                    data: 'new_department',
                },
                {
                    name: 'request_transfer_date',
                    data: 'request_transfer_date',
                },
                {
                    name: 'justifikasi',
                    data: 'justifikasi',
                },
                {
                    name: 'remark',
                    data: 'remark',
                },
                {
                    name: 'note',
                    data: 'note',
                },
                {
                    name: 'transfer_date',
                    data: 'transfer_date',
                },
                {
                    name: 'tanggal_bast',
                    data: 'tanggal_bast',
                },
                {
                    name: 'no_bast',
                    data: 'no_bast',
                },
                {
                    name: 'file_bast',
                    data: 'file_bast',
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
        $('#filter-asset_transfer_submit').click(function (e) {
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
                url: "/reports/asset-transfers/export",
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
                    a.download = 'asset-transfers.xlsx';
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

    var buildSelect = () => {
        selectProject();
        selectEmployee();
    }

    var selectProject = () => {
        var project = {
            url: '/global/projects/data-for-select',
            field: [
                'old_project',
                'new_project',
            ],
            key: 'project_id',
            value: 'project',
            selected: null
        }
        var request = initSelect(...Object.values(project));
        $.when(request).done(function () {
            $('select[name="old_project"]').next().find('.select2-selection__placeholder').text('Old Project')
            $('select[name="new_project"]').next().find('.select2-selection__placeholder').text('New Project')
        });
    }

    var selectEmployee = () => {
        var employee = {
            url: '/global/employees/data-for-select',
            field: [
                'old_pic',
                'new_pic',
            ],
            key: 'nik',
            value: 'nama_karyawan',
            selected: null
        }
        var request = initSelect(...Object.values(employee));
        $.when(request).done(function () {
            $('select[name="old_pic"]').next().find('.select2-selection__placeholder').text('Old PIC')
            $('select[name="new_pic"]').next().find('.select2-selection__placeholder').text('New PIC')
        });
    }

    var initSelect = (url, field, key, value, selected, keyData) => {
        return $.ajax({
            url: url,
            method: "POST",
            type: 'application/json',
            success: function (data) {
                if (Array.isArray(field)) {
                    $.each(field, function (index, fiel) {
                        $(`select[name="${fiel}"]`).empty();
                        $(`select[name="${fiel}"]`).append(`<option></option>`)
                        $.each(data, function (index, dat) {
                            var attr = `data-${keyData}="${getValueFromJSON(dat, keyData)}"`;
                            var dataKey = getValueFromJSON(dat, key);
                            $(`select[name="${fiel}"]`).append(
                                `<option ${keyData ? attr : ''} value="${dataKey}" ${selected == dataKey ? 'selected' : ''}>${getValueFromJSON(dat, value)}</option>`
                            );
                        })
                    });
                } else {
                    $(`select[name="${field}"]`).empty();
                    $(`select[name="${field}"]`).append(`<option></option>`)
                    $.each(data, function (index, dat) {
                        var attr = `data-${keyData}="${getValueFromJSON(dat, keyData)}"`;
                        var dataKey = getValueFromJSON(dat, key);
                        $(`select[name="${field}"]`).append(
                            `<option ${keyData ? attr : ''} value="${dataKey}" ${selected == dataKey ? 'selected' : ''}>${getValueFromJSON(dat, value)}</option>`
                        );
                    })
                }
            }
        });
    }

    function getValueFromJSON(json, key) {
        if (json.hasOwnProperty(key)) {
            return json[key];
        } else {
            return null;
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
            buildSelect()
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    index.init();
});
