"use strict";

var form = function () {
    var datatableDepre;

    var initialDatatableDepre = () => {
        datatableDepre = $('#depresiasi_table').DataTable({
            dom: 'frtip',
        });
    }

    var clearDatatableDepre = () => {
        datatableDepre.clear();
        datatableDepre.destroy();
        $("#depresiasi_table tbody").empty();
    }

    var loadDatatableDepre = (response) => {
        if (datatableDepre != null) {
            clearDatatableDepre();
        }
        $.each(response.result, function (indexInArray, valueOfElement) {
            $('.depresiasi-container').append(`
                <tr>
                    <td>${++indexInArray}</td>
                    <td>${valueOfElement.date}</td>
                    <td>${valueOfElement.depreciation}</td>
                    <td>${valueOfElement.sisa}</td>
                </tr>
            `);
        });
        $('input[name="nilai_sisa"]').val(response.current_sisa).trigger('input');
        initialDatatableDepre()
    }

    function addMonths(date, months) {
        var newDate = new Date(date);
        newDate.setMonth(newDate.getMonth() + months);
        return newDate;
    }

    function formatDateToYYYYMMDD(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }

    var initEvents = () => {
        $('select[name="jangka_waktu_leasing"]').change(function (e) {
            e.preventDefault();
            var month = parseInt($(this).find(':selected').text());
            var date = $('input[name="tanggal_awal_leasing"]').val();
            if (date) {
                $('input[name="tanggal_akhir_leasing"]').val(formatDateToYYYYMMDD(addMonths(date, month))).trigger('input');
            }
        });
        $('input[name="tanggal_awal_leasing"]').change(function (e) {
            e.preventDefault();
            var month = parseInt($('select[name="jangka_waktu_leasing"]').find(':selected').text());
            var date = $(this).val();
            $('input[name="tanggal_akhir_leasing"]').val(formatDateToYYYYMMDD(addMonths(date, month))).trigger('input');
        });
        $('select[name="jangka_waktu_insurance"]').change(function (e) {
            e.preventDefault();
            var month = parseInt($(this).find(':selected').text());
            var date = $('input[name="tanggal_awal_insurance"]').val();
            if (date) {
                $('input[name="tanggal_akhir_insurance"]').val(formatDateToYYYYMMDD(addMonths(date, month))).trigger('input');
            }
        });
        $('input[name="tanggal_awal_insurance"]').change(function (e) {
            e.preventDefault();
            var month = parseInt($('select[name="jangka_waktu_insurance"]').find(':selected').text());
            var date = $(this).val();
            $('input[name="tanggal_akhir_insurance"]').val(formatDateToYYYYMMDD(addMonths(date, month))).trigger('input');
        });
        $('input[name="harga_beli_leasing"]').keyup(function (e) {
            $('input[name="price"]').val($(this).val()).trigger('input');
        });
        $('input[name="tgl_bast"]').change(function (e) {
            e.preventDefault();
            $('input[name="date"]').val($(this).val());
        });
        $('select[name="lifetime_id"]').change(function (e) {
            e.preventDefault();
            generateDepre();
        });
        $('input[name="nilai_sisa"]').change(function (e) {
            e.preventDefault();
            generateDepre();
        });
    }

    var generateDepre = () => {
        $.ajax({
            type: "POST",
            url: `/asset-masters/depreciation`,
            data: {
                date: $('input[name="date"]').val(),
                price: $('input[name="price"]').val(),
                nilai_sisa: $('input[name="nilai_sisa"]').val(),
                lifetime_id: $('select[name="lifetime_id"]').val(),
            },
            dataType: "JSON",
            success: function (response) {
                loadDatatableDepre(response);
            },
            error: function (jqXHR, xhr, textStatus, errorThrow, exception) {
                if (jqXHR.status == 422) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan!',
                        text: JSON.parse(jqXHR.responseText)
                            .message,
                    });
                } else if (jqXHR.status == 419) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: JSON.parse(jqXHR.responseText)
                            .message,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: jqXHR.responseText,
                    })
                }
            }
        });
    }

    function currencyToInt(currency) {
        return parseInt(currency.replace(/[^\d.-]|(?<=\d)\.(?=\d)/g, ''));
    }

    var initPlugins = () => {
        $("#tgl_bast").flatpickr();
        $("#tanggal_perolehan_leasing").flatpickr();
        $("#tanggal_awal_leasing").flatpickr();
        $("#tanggal_perolehan_insurance").flatpickr();
        $("#tanggal_awal_insurance").flatpickr();
        $('.uang').mask('0.000.000.000', {
            reverse: true
        });
        new tempusDominus.TempusDominus(document.getElementById("tahun_pembuatan"), {
            display: {
                viewMode: "calendar",
                components: {
                    decades: true,
                    year: true,
                    month: false,
                    date: false,
                    hours: false,
                    minutes: false,
                    seconds: false
                }
            },
            localization: {
                format: 'yyyy'
            }
        });
    }

    var initAllSelects = () => {
        var uom = {
            url: 'master/uoms/data-for-select',
            field: 'uom_id',
            key: 'id',
            value: 'name',
            selected: null
        }
        initSelect(...Object.values(uom));
        var subCluster = {
            url: 'master/sub-clusters/data-for-select',
            field: 'sub_cluster_id',
            key: 'id',
            value: 'name',
            selected: null
        }
        initSelect(...Object.values(subCluster));
        var unit = {
            url: 'master/units/data-for-select',
            field: 'unit_unit_id',
            key: 'id',
            value: 'model',
            selected: null,
            keyData: 'prefix'
        }
        initSelect(...Object.values(unit));
        var activity = {
            url: 'master/activities/data-for-select',
            field: 'activity_id',
            key: 'id',
            value: 'name',
            selected: null
        }
        initSelect(...Object.values(activity));
        var condition = {
            url: 'master/conditions/data-for-select',
            field: 'condition_id',
            key: 'id',
            value: 'name',
            selected: null
        }
        initSelect(...Object.values(condition));
        var dealer = {
            url: 'master/dealers/data-for-select',
            field: 'dealer_id_leasing',
            key: 'vendorid',
            value: 'vendorname',
            selected: null
        }
        initSelect(...Object.values(dealer));
        var leasing = {
            url: 'master/leasings/data-for-select',
            field: 'leasing_id_leasing',
            key: 'id',
            value: 'name',
            selected: null
        }
        initSelect(...Object.values(leasing));
        var project = {
            url: 'global/projects/data-for-select',
            field: 'asset_location',
            key: 'project_id',
            value: 'project',
            selected: null
        }
        initSelect(...Object.values(project));
        var employee = {
            url: 'global/employees/data-for-select',
            field: 'pic',
            key: 'nik',
            value: 'nama_karyawan',
            selected: null
        }
        initSelect(...Object.values(employee));
        var lifetime = {
            url: 'master/lifetimes/data-for-select',
            field: [
                'jangka_waktu_leasing',
                'jangka_waktu_insurance',
                'lifetime_id',
            ],
            key: 'masa_pakai',
            value: 'masa_pakai',
            selected: null
        }
        initSelect(...Object.values(lifetime));
    }

    var initSelect = (url, field, key, value, selected, keyData) => {
        $.ajax({
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
            initEvents();
            initPlugins();
            initAllSelects();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    form.init();
});
