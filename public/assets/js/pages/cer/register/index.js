"use strict";

var index = function () {
    var datatable;

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

    var iniEvents = () => {
        $('#cer_item_table').on('click', '.btn-history', function (e) {
            e.preventDefault();
            var id = $(this).data('cer-item');
            var self = this;
            $(self).attr("data-kt-indicator", "on");
            $.ajax({
                type: "GET",
                url: `/asset-registers/${id}/history`,
                dataType: "JSON",
                success: function (response) {
                    $('#timeline').modal('show');
                    $('.nopr').text(response[0].no);
                    $('.prdate').text(response[0].date);
                    $('.statuspr').html(response[0].badge);

                    $('.nopo').text(response[1].no);
                    $('.podate').text(response[1].date);
                    $('.statuspo').html(response[1].badge);


                    $('.nogr').text(response[2].no);
                    $('.grdate').text(response[2].date);
                    $('.statusgr').html(response[2].badge);
                    if (response[2].doc_bast) {
                        $('.link-doc-bast').html(`<a target="_blank" href="${response[2].doc_bast}" class="badge badge-success fs-7">Document BAST</a>`);
                    }

                    if (response['is_register']) {
                        $('.btn-register').removeClass('d-none');
                    }
                    $(self).removeAttr("data-kt-indicator");

                    $('.btn-register').attr('href', `/asset-registers/${id}/register`);
                },
                error: function (jqXHR, xhr, textStatus, errorThrow, exception) {
                    $(self).removeAttr("data-kt-indicator");
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

        $('[data-bs-dismiss="modal"]').click(function (e) {
            e.preventDefault();
            $('.nopr').text('');
            $('.prdate').text('');
            $('.statuspr').html('');

            $('.nopo').text('');
            $('.podate').text('');
            $('.statuspo').html('');

            $('.nogr').text('');
            $('.grdate').text('');
            $('.statusgr').html('');

            $('.btn-register').addClass('d-none');
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
            iniEvents();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    index.init();
});
