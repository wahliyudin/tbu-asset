"use strict";

var KTModalAdd = function () {
    var datatableAsset;
    var modalAsset;
    var justifikasi;

    var initPlugins = () => {
        $(".date").flatpickr();
        $('.uang').mask('0.000.000.000', {
            reverse: true
        });
        initCkEditor();
    }

    var initCkEditor = () => {
        ClassicEditor.create(document.querySelector('#justifikasi'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList'],
            heading: {
                options: [{
                    model: 'paragraph',
                    title: 'Paragraph',
                    class: 'ck-heading_paragraph'
                },
                {
                    model: 'heading1',
                    view: 'h1',
                    title: 'Heading 1',
                    class: 'ck-heading_heading1'
                },
                {
                    model: 'heading2',
                    view: 'h2',
                    title: 'Heading 2',
                    class: 'ck-heading_heading2'
                }
                ]
            }
        })
            .then(editor => {
                justifikasi = editor;
            })
            .catch(error => {
                console.error(error);
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
                url: "/asset-transfers/datatable-asset",
                data: function (d) {
                    d.search = $('#data_asset input[name="search"]').val();
                }
            },
            columns: [{
                name: 'action',
                data: 'action',
                orderable: false,
                searchable: false
            },
            {
                name: 'nama',
                data: 'nama',
            },
            {
                name: 'merk_tipe_model',
                data: 'merk_tipe_model',
            },
            {
                name: 'serial_number',
                data: 'serial_number',
            },
            {
                name: 'nomor_asset',
                data: 'nomor_asset',
            },
            {
                name: 'niali_buku',
                data: 'niali_buku',
            },
            {
                name: 'kelengkapan',
                data: 'kelengkapan',
            },],
        });

        const filterSearch = document.querySelector('[data-kt-data-asset-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            datatableAsset.ajax.reload();
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
            getEmployeeByAsset(asset);
            modalAsset.hide();
        });
    }

    var getEmployeeByAsset = (asset) => {
        $.ajax({
            type: 'GET',
            url: `/asset-transfers/${asset}/employee`,
            dataType: "JSON",
            success: function (response) {
                populateEmployee(response);
            },
            error: function (jqXHR, xhr, textStatus, errorThrow, exception) {

            }
        });
    }

    var populateEmployee = (employee) => {
        $('input[name="old_pic"]').val(employee?.nik ?? '-');
        $('input[name="old_nama_karyawan"]').val(employee?.nama_karyawan ?? '-');
        $('input[name="old_department"]').val(employee?.position?.department?.department_name ?? '-');
        $('input[name="old_divisi"]').val(employee?.position?.divisi?.division_name ?? '-');
        $('input[name="old_project"]').val(employee?.position?.project?.project ?? '-');
        $('input[name="old_location"]').val(employee?.position?.project?.location ?? '-');
    }

    var populateItem = (arrayTd, key) => {
        $('input[name="asset_id"]').val(key);
        $('#nama').text(arrayTd[1].innerText);
        $('#merk_tipe_model').text(arrayTd[2].innerText);
        $('#serial_number').text(arrayTd[3].innerText);
        $('#nomor_asset').text(arrayTd[4].innerText);
        $('#niali_buku').text(arrayTd[5].innerText);
        $('#kelengkapan').text(arrayTd[6].innerText);
    }

    var initForm = () => {
        $(`.form-transfer`).on('click', `.simpan-form-transfer`, function (e) {
            e.preventDefault();
            var postData = new FormData($(`.form-transfer`)[0]);
            postData.append('justifikasi', justifikasi.getData());
            $(`.simpan-form-transfer`).attr("data-kt-indicator", "on");
            $.ajax({
                type: 'POST',
                url: "/asset-transfers/store",
                processData: false,
                contentType: false,
                data: postData,
                success: function (response) {
                    $(`.simpan-form-transfer`).removeAttr("data-kt-indicator");
                    Swal.fire(
                        'Success!',
                        response.message,
                        'success'
                    ).then(function () {
                        window.location.href = "/asset-transfers";
                    });
                },
                error: function (jqXHR, xhr, textStatus, errorThrow, exception) {
                    $(`.simpan-form-transfer`).removeAttr("data-kt-indicator");
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
