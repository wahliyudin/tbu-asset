"use strict";

var detail = function () {
    var datatableDepre = null;

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
        $('.nilai_sisa').text(formatRupiah(response.current_sisa));
        initialDatatableDepre()
    }

    function formatRupiah(angka) {
        var bilangan = angka;
        var reverse = bilangan.toString().split('').reverse().join('');
        var ribuan = reverse.match(/\d{1,3}/g);
        return ribuan.join('.').split('').reverse().join('');
    }

    var generateDatatableDepre = () => {
        $.ajax({
            type: "POST",
            url: `/asset-masters/depreciation`,
            data: {
                date: $('input[name="date"]').val(),
                price: $('input[name="price"]').val(),
                nilai_sisa: $('input[name="nilai_sisa"]').val(),
                lifetime_id: $('input[name="lifetime_id"]').val(),
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

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            generateDatatableDepre();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    detail.init();
});
