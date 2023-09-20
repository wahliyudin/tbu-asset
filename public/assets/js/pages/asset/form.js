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
        $.each(response, function (indexInArray, valueOfElement) {
            $('.depresiasi-container').append(`
                <tr>
                    <td>${++indexInArray}</td>
                    <td>${valueOfElement.date}</td>
                    <td>${valueOfElement.depreciation}</td>
                    <td>${valueOfElement.sisa}</td>
                </tr>
            `);
        });
        initialDatatableDepre()
    }

    var initEvents = () => {
        $('input[name="harga_beli_leasing"]').keyup(function (e) {
            $('input[name="price"]').val($(this).val()).trigger('input');
        });
        $('input[name="tgl_bast"]').change(function (e) {
            e.preventDefault();
            $('input[name="date"]').val($(this).val());
        });
        $('input[name="umur_asset"]').change(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: `/asset-masters/depreciation`,
                data: {
                    date: $('input[name="date"]').val(),
                    price: $('input[name="price"]').val(),
                    umur_asset: $('input[name="umur_asset"]').val(),
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
        });
    }

    function currencyToInt(currency) {
        return parseInt(currency.replace(/[^\d.-]|(?<=\d)\.(?=\d)/g, ''));
    }

    var initPlugins = () => {
        $("#tgl_bast").flatpickr();
        $("#tanggal_perolehan_leasing").flatpickr();
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

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            initEvents();
            initPlugins();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    form.init();
});
