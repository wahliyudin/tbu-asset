"use strict";

var KTModalAdd = function () {
    var datatableAsset;
    var modalAsset;

    var initPlugins = () => {
        $(".date").flatpickr();
        $('.uang').mask('0.000.000.000', {
            reverse: true
        });
    }

    var initDatatableAsset = () => {
        datatableAsset = $('#data-asset_table').DataTable({
            processing: true,
            order: [
                [1, 'asc']
            ],
            ajax: {
                type: "POST",
                url: "/asset-disposes/datatable-asset",
                data: function (d) {
                    d.search = $('#data-asset_table input[name="search"]').val();
                }

            },
            columns: [{
                name: 'action',
                data: 'action',
                orderable: false,
                searchable: false
            },
            {
                name: 'description',
                data: 'description',
            },
            {
                name: 'model_spesification',
                data: 'model_spesification',
            },
            {
                name: 'serial_no',
                data: 'serial_no',
            },
            {
                name: 'no_asset',
                data: 'no_asset',
            },
            {
                name: 'tahun_buat',
                data: 'tahun_buat',
            },
            {
                name: 'nilai_buku',
                data: 'nilai_buku',
            },],
        });

        const filterSearch = document.querySelector('[data-kt-data-asset-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            datatableAsset.search(e.target.value).draw();
        });

        initActionAsset();
    }

    var initActionAsset = () => {
        $('#data_asset_close').click(function (e) {
            e.preventDefault();
            modalAsset.hide();
        });
        $('.btn-select-asset').click(function (e) {
            e.preventDefault();
            modalAsset.show();
        });
        $('#data-asset_table').on('click', '.select-asset', function (e) {
            e.preventDefault();
            var asset = $(this).data('asset');
            const parent = e.target.closest('tr');
            var arrayTd = parent.querySelectorAll('td');
            populateItem(arrayTd, asset);
            modalAsset.hide();
        });
    }

    var populateItem = (arrayTd, key) => {
        $('.table-asset-selected input[name="asset_id"]').val(key);
        $('.table-asset-selected input[name="description"]').val(arrayTd[1].innerText);
        $('.table-asset-selected input[name="model_spesification"]').val(arrayTd[2].innerText);
        $('.table-asset-selected input[name="serial_no"]').val(arrayTd[3].innerText);
        $('.table-asset-selected input[name="no_asset"]').val(arrayTd[4].innerText);
        $('.table-asset-selected input[name="tahun_buat"]').val(arrayTd[5].innerText);
        $('.table-asset-selected input[name="nilai_buku"]').val(arrayTd[6].innerText).trigger('input');
    }

    var initForm = () => {
        $(`.form-dispose`).on('click', `.simpan-form-dispose`, function (e) {
            e.preventDefault();
            var postData = new FormData($(`.form-dispose`)[0]);
            $(`.simpan-form-dispose`).attr("data-kt-indicator", "on");
            $.ajax({
                type: 'POST',
                url: "/asset-disposes/store",
                processData: false,
                contentType: false,
                data: postData,
                success: function (response) {
                    $(`.simpan-form-dispose`).removeAttr("data-kt-indicator");
                    Swal.fire(
                        'Success!',
                        response.message,
                        'success'
                    ).then(function () {
                        window.location.href = "/asset-disposes";
                    });
                },
                error: function (jqXHR, xhr, textStatus, errorThrow, exception) {
                    $(`.simpan-form-dispose`).removeAttr("data-kt-indicator");
                    if (jqXHR.status == 422) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan!',
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

    function numberFromString(s) {
        return typeof s === 'string' ?
            s.replace(/[\$.]/g, '') * 1 :
            typeof s === 'number' ?
                s : 0;
    }

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            modalAsset = new bootstrap.Modal(document.querySelector('#data_asset'));

            initPlugins();
            initDatatableAsset();
            initForm();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTModalAdd.init();
});
