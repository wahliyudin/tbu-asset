"use strict";

var historyTransfer = function () {
    var datatable;
    var table;

    var initDatatable = function () {
        datatable = $('#history_transfer_table').DataTable({
            processing: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: "/asset-transfers/histories/datatable"
            },
            columns: [
                {
                    name: 'id_asset',
                    data: 'id_asset',
                },
                {
                    name: 'model',
                    data: 'model',
                },
                {
                    name: 'type',
                    data: 'type',
                },
                {
                    name: 'pic',
                    data: 'pic',
                },
                {
                    name: 'action',
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });
    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-history-transfer-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    var handleShow = () => {
        $('#history_transfer_table').on('click', '.btn-show', function (e) {
            e.preventDefault();
            var asset = $(this).data('asset');
            $("#list-history").empty();
            $('#timeline').modal('show');
            $('.loading').removeClass('d-none');
            $.ajax({
                type: "POST",
                url: `/asset-transfers/histories/${asset}/show`,
                dataType: "JSON",
                success: function (response) {
                    $('.loading').addClass('d-none');
                    $('#list-history').append(`
                        <div class="py-0 d-none" data-kt-customer-payment-method="row"></div>
                    `);
                    $(response).each(function (index, element) {
                        $('#list-history').append(historyItem(element));
                    });
                },
                error: function (jqXHR) {

                }
            });
        });
    }

    var tamestampToFormat = (inputDate, format = "D MMMM YYYY, HH:mm:ss") => {
        var parsedDate = moment(inputDate);
        parsedDate.locale('id');
        return parsedDate.format(format);
    }

    var historyItem = (transfer) => {
        return `
        <div class="py-0" data-kt-customer-payment-method="row">
            <div class="py-3 d-flex flex-stack flex-wrap">
                <div class="accordion-header d-flex align-items-center collapsed"
                    data-bs-toggle="collapse" href="#history-item-${transfer.id}" role="button"
                    aria-expanded="false" aria-controls="history-item-${transfer.id}">
                    <div class="accordion-icon me-2">
                        <i class="ki-duotone ki-right fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <div class="d-flex align-items-center">
                            <div class="text-gray-800 fw-bold">${transfer.no_transaksi}</div>
                        </div>
                        <div class="text-muted">${tamestampToFormat(transfer.created_at)}</div>
                    </div>
                </div>
                <div class="d-flex my-3 ms-9 align-items-center">
                    <div class="me-3">
                        <div class="d-flex align-items-center">
                            <div class="text-gray-800 fw-bold">${transfer.old_location}</div>
                        </div>
                    </div>
                    <div class="mx-5">
                        <i class="ki-duotone ki-black-right fs-1"></i>
                    </div>
                    <div class="ms-3">
                        <div class="d-flex align-items-center">
                            <div class="text-gray-800 fw-bold">${transfer.new_location}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="history-item-${transfer.id}" class="collapse fs-6 ps-10"
                data-bs-parent="#list-history">
                <div class="d-flex flex-wrap py-5">
                    <div class="flex-equal me-5">
                        <table class="table table-flush fw-semibold gy-1">
                            <tr>
                                <td class="text-muted min-w-125px w-125px">
                                    PIC</td>
                                <td class="text-gray-800">${transfer.old_pic.nama_karyawan}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted min-w-125px w-125px">
                                    Location</td>
                                <td class="text-gray-800">${transfer.old_location}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted min-w-125px w-125px">
                                    Divisi</td>
                                <td class="text-gray-800">${transfer.old_divisi}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted min-w-125px w-125px">
                                    Department</td>
                                <td class="text-gray-800">${transfer.old_department}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="flex-equal">
                        <table class="table table-flush fw-semibold gy-1">
                            <tr>
                                <td class="text-muted min-w-125px w-125px">
                                    PIC</td>
                                <td class="text-gray-800">${transfer.new_pic.nama_karyawan}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted min-w-125px w-125px">
                                    Location</td>
                                <td class="text-gray-800">${transfer.new_location}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted min-w-125px w-125px">
                                    Divisi</td>
                                <td class="text-gray-800">${transfer.new_divisi}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted min-w-125px w-125px">
                                    Department</td>
                                <td class="text-gray-800">${transfer.new_department}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-flush fw-semibold gy-1">
                    <tr>
                        <td class="text-muted min-w-70px w-70px">
                            File BAST</td>
                        <td class="text-gray-800">
                            <a target="_blank" href="/storage/${transfer.file_bast}" class="badge badge-success fs-7">Document BAST</a>
                        </td>
                        <td class="text-muted min-w-70px w-70px">
                            No BAST</td>
                        <td class="text-gray-800">
                            ${transfer.no_bast}
                        </td>
                        <td class="text-muted min-w-100px w-100px">
                            Tanggal BAST</td>
                        <td class="text-gray-800">
                            ${tamestampToFormat(transfer.tanggal_bast, 'D MMMM YYYY')}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="separator separator-dashed"></div>
        `;
    }

    var handleError = function (jqXHR) {
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
    };

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            initDatatable();
            handleSearchDatatable();
            handleShow();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    historyTransfer.init();
});
