"use strict";

var TransfersList = function () {
    var datatable;
    var table;
    var submitButton;
    var cancelButton;
    var closeButton;
    var validator;
    var form;
    var modal;

    var initTransferList = function () {
        const tableRows = table.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
            const realDate = moment(dateRow[5].innerHTML, "DD MMM YYYY, LT").format(); // select date from 5th column in table
            dateRow[5].setAttribute('data-order', realDate);
        });
        datatable = $(table).DataTable({
            processing: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: "/asset-transfers/datatable",
                // data: function (d) {
                //     d.search = $('input[name="search"]').val();
                // }
            },
            columns: [
                {
                    name: 'no_transaksi',
                    data: 'no_transaksi',
                },
                {
                    name: 'asset',
                    data: 'asset',
                },
                {
                    name: 'old_pic',
                    data: 'old_pic',
                },
                {
                    name: 'new_pic',
                    data: 'new_pic',
                },
                {
                    name: 'status_transfer',
                    data: 'status_transfer',
                },
                {
                    name: 'status',
                    data: 'status',
                },
                {
                    name: 'action',
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        datatable.on('draw', function () {
            handleReceived();
            handleDeleteRow();
        });
    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-transfer-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            // datatable.ajax.reload();
            datatable.search(e.target.value).draw();
        });
    }

    var handleReceived = () => {
        $('#received').on('hidden.bs.modal', function () {
            $('#received_submit').data('transfer', '');
        });
        $('#transfer_table').on('click', '.btn-received', function () {
            var transfer = $(this).data('transfer');
            $('#received_submit').data('transfer', transfer);
            $('#received').modal('show');
            initDatatableBudget(transfer);
        });
        $('#received_submit').click(function (e) {
            e.preventDefault();
            var transfer = $(this).data('transfer');
            var target = this;
            var postData = new FormData($(`#received_form`)[0]);
            $(target).attr("data-kt-indicator", "on");
            $.ajax({
                type: 'POST',
                url: `/asset-transfers/${transfer}/received`,
                processData: false,
                contentType: false,
                data: postData,
                success: function (response) {
                    $(target).removeAttr('data-kt-indicator');
                    Swal.fire({
                        text: "Form has been successfully submitted!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                },
                error: function (jqXHR) {
                    handleError(jqXHR, target);
                }
            });
        });
    }

    var initDatatableBudget = (transfer) => {
        $('#budgets_table').DataTable().destroy();
        $('#budgets_table').DataTable({
            processing: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: `/asset-transfers/${transfer}/datatable-budget`
            },
            columns: [
                {
                    name: 'remaining',
                    data: 'remaining',
                },
                {
                    name: 'description',
                    data: 'description',
                },
            ],
        });
    }

    var initPlugins = () => {
        $('#tanggal_bast').flatpickr();
    }

    var handleDeleteRow = () => {
        $('#transfer_table').on('click', '.btn-delete', function () {
            var transfer = $(this).data('transfer');
            var target = this;
            $(target).attr("data-kt-indicator", "on");
            Swal.fire({
                text: "Are you sure you want to delete ?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: `/asset-transfers/${transfer}/destroy`,
                        dataType: "JSON",
                        success: function (response) {
                            $(target).removeAttr("data-kt-indicator");
                            Swal.fire({
                                text: "You have deleted !.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function () {
                                datatable.ajax.reload();
                            });
                        },
                        error: function (jqXHR) {
                            handleError(jqXHR, target);
                        }
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "was not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function () {
                        $(target).removeAttr("data-kt-indicator");
                    });
                }
            });

        });
    }

    var handleError = function (jqXHR, target) {
        $(target).removeAttr("data-kt-indicator");
        if (target) {
            target.disabled = false;
        }
        if (jqXHR.status == 422 || jqXHR.responseJSON.message.includes("404")) {
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

    var buttonCreate = () => {
        $('[data-bs-target="#create-transfer"]').on('click', function () {
            $($(form).find('input[name="name"]')).val('');
            $(submitButton).data('transfer', '');
        });
    }

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            table = document.querySelector('#transfer_table');
            if (!table) {
                return;
            }
            initTransferList();
            handleSearchDatatable();
            handleDeleteRow();
            initPlugins();

            $(".date").flatpickr();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    TransfersList.init();
});
