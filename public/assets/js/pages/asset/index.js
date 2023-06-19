"use strict";

var AssetsList = function () {
    var datatable;
    var table;
    var submitButton;
    var cancelButton;
    var closeButton;
    var validator;
    var form;
    var modal;

    var initCategoryList = function () {
        const tableRows = table.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
            const realDate = moment(dateRow[5].innerHTML, "DD MMM YYYY, LT").format(); // select date from 5th column in table
            dateRow[5].setAttribute('data-order', realDate);
        });
        datatable = $(table).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: "/asset-masters/datatable"
            },
            columns: [
                {
                    name: 'kode',
                    data: 'kode',
                },
                {
                    name: 'kode_unit',
                    data: 'kode_unit',
                },
                {
                    name: 'unit_model',
                    data: 'unit_model',
                },
                {
                    name: 'unit_type',
                    data: 'unit_type',
                },
                {
                    name: 'asset_location',
                    data: 'asset_location',
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

        datatable.on('draw', function () {
            handleDeleteRow();
        });
    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-asset-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    var handleDeleteRow = () => {
        $('#asset_table').on('click', '.btn-delete', function () {
            var asset = $(this).data('asset');
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
                        url: `/asset-masters/${asset}/destroy`,
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
                        error: handleError
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

    var handleForm = function () {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'kode': {
                        validators: {
                            notEmpty: {
                                message: 'Kode is required'
                            }
                        }
                    },
                    'unit_id': {
                        validators: {
                            notEmpty: {
                                message: 'Unit is required'
                            }
                        }
                    },
                    'sub_cluster_id': {
                        validators: {
                            notEmpty: {
                                message: 'Sub Cluster is required'
                            }
                        }
                    },
                    'member_name': {
                        validators: {
                            notEmpty: {
                                message: 'Member Name is required'
                            }
                        }
                    },
                    'pic': {
                        validators: {
                            notEmpty: {
                                message: 'PIC is required'
                            }
                        }
                    },
                    'activity': {
                        validators: {
                            notEmpty: {
                                message: 'Activity is required'
                            }
                        }
                    },
                    'asset_location': {
                        validators: {
                            notEmpty: {
                                message: 'Asset Location is required'
                            }
                        }
                    },
                    'kondisi': {
                        validators: {
                            notEmpty: {
                                message: 'Kondisi is required'
                            }
                        }
                    },
                    'uom': {
                        validators: {
                            notEmpty: {
                                message: 'UOM is required'
                            }
                        }
                    },
                    'quantity': {
                        validators: {
                            notEmpty: {
                                message: 'quantity is required'
                            }
                        }
                    },
                    'tgl_bast': {
                        validators: {
                            notEmpty: {
                                message: 'Tanggal Bast is required'
                            }
                        }
                    },
                    'hm': {
                        validators: {
                            notEmpty: {
                                message: 'HM is required'
                            }
                        }
                    },
                    'pr_number': {
                        validators: {
                            notEmpty: {
                                message: 'PR Number is required'
                            }
                        }
                    },
                    'po_number': {
                        validators: {
                            notEmpty: {
                                message: 'PO Number is required'
                            }
                        }
                    },
                    'gr_number': {
                        validators: {
                            notEmpty: {
                                message: 'GR Number is required'
                            }
                        }
                    },
                    'remark': {
                        validators: {
                            notEmpty: {
                                message: 'Remark is required'
                            }
                        }
                    },
                    'status': {
                        validators: {
                            notEmpty: {
                                message: 'Status is required'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;
                        $.ajax({
                            type: "POST",
                            url: "/asset-masters/store",
                            data: {
                                key: $(submitButton).data('asset'),
                                kode: $($(form).find('input[name="kode"]')).val(),
                                unit_id: $($(form).find('select[name="unit_id"]')).val(),
                                sub_cluster_id: $($(form).find('select[name="sub_cluster_id"]')).val(),
                                member_name: $($(form).find('input[name="member_name"]')).val(),
                                pic: $($(form).find('input[name="pic"]')).val(),
                                activity: $($(form).find('input[name="activity"]')).val(),
                                asset_location: $($(form).find('input[name="asset_location"]')).val(),
                                kondisi: $($(form).find('input[name="kondisi"]')).val(),
                                uom: $($(form).find('input[name="uom"]')).val(),
                                quantity: $($(form).find('input[name="quantity"]')).val(),
                                tgl_bast: $($(form).find('input[name="tgl_bast"]')).val(),
                                hm: $($(form).find('input[name="hm"]')).val(),
                                pr_number: $($(form).find('input[name="pr_number"]')).val(),
                                po_number: $($(form).find('input[name="po_number"]')).val(),
                                gr_number: $($(form).find('input[name="gr_number"]')).val(),
                                remark: $($(form).find('input[name="remark"]')).val(),
                                status: $($(form).find('select[name="status"]')).val(),
                            },
                            dataType: "JSON",
                            success: function (response) {
                                submitButton.removeAttribute('data-kt-indicator');
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
                                        modal.hide();
                                        submitButton.disabled = false;
                                        datatable.ajax.reload();
                                    }
                                });
                            },
                            error: handleError
                        });
                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });

        cancelButton.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset();
                    modal.hide();
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });

        closeButton.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset();
                    modal.hide();
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        })
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
    };

    var buttonCreate = () => {
        $('[data-bs-target="#create-asset"]').on('click', function () {
            $($(form).find('input[name="kode"]')).val('');
            $($(form).find('select[name="unit_id"]')).val('').trigger('change');
            $($(form).find('select[name="sub_cluster_id"]')).val('').trigger('change');
            $($(form).find('input[name="member_name"]')).val('');
            $($(form).find('input[name="pic"]')).val('');
            $($(form).find('input[name="activity"]')).val('');
            $($(form).find('input[name="asset_location"]')).val('');
            $($(form).find('input[name="kondisi"]')).val('');
            $($(form).find('input[name="uom"]')).val('');
            $($(form).find('input[name="quantity"]')).val('');
            $($(form).find('input[name="tgl_bast"]')).val('');
            $($(form).find('input[name="hm"]')).val('');
            $($(form).find('input[name="pr_number"]')).val('');
            $($(form).find('input[name="po_number"]')).val('');
            $($(form).find('input[name="gr_number"]')).val('');
            $($(form).find('input[name="remark"]')).val('');
            $($(form).find('select[name="status"]')).val('');
            $(submitButton).data('asset', '');
        });
    }

    var buttonEdit = () => {
        $('#asset_table').on('click', '.btn-edit', function () {
            var target = this;
            $(target).attr("data-kt-indicator", "on");
            var asset = $(this).data('asset');
            $(submitButton).data('asset', asset);
            $.ajax({
                type: "POST",
                url: `/asset-masters/${asset}/edit`,
                dataType: "JSON",
                success: function (response) {
                    $($(form).find('input[name="kode"]')).val(response.kode);
                    $($(form).find('select[name="unit_id"]')).val(response.unit_id).trigger('change');
                    $($(form).find('select[name="sub_cluster_id"]')).val(response.sub_cluster_id).trigger('change');
                    $($(form).find('input[name="member_name"]')).val(response.member_name);
                    $($(form).find('input[name="pic"]')).val(response.pic);
                    $($(form).find('input[name="activity"]')).val(response.activity);
                    $($(form).find('input[name="asset_location"]')).val(response.asset_location);
                    $($(form).find('input[name="kondisi"]')).val(response.kondisi);
                    $($(form).find('input[name="uom"]')).val(response.uom);
                    $($(form).find('input[name="quantity"]')).val(response.quantity);
                    $($(form).find('input[name="tgl_bast"]')).val(response.tgl_bast);
                    $($(form).find('input[name="hm"]')).val(response.hm);
                    $($(form).find('input[name="pr_number"]')).val(response.pr_number);
                    $($(form).find('input[name="po_number"]')).val(response.po_number);
                    $($(form).find('input[name="gr_number"]')).val(response.gr_number);
                    $($(form).find('input[name="remark"]')).val(response.remark);
                    $($(form).find('select[name="status"]')).val(response.status).trigger('change');
                    $(target).removeAttr("data-kt-indicator");
                    modal.show();
                },
                error: handleError
            });
        });
    }

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            table = document.querySelector('#asset_table');
            if (!table) {
                return;
            }
            initCategoryList();
            handleSearchDatatable();
            handleDeleteRow();


            modal = new bootstrap.Modal(document.querySelector('#create-asset'));
            form = document.querySelector('#create-asset_form');
            submitButton = form.querySelector('#create-asset_submit');
            cancelButton = form.querySelector('#create-asset_cancel');
            closeButton = form.querySelector('#create-asset_close');

            handleForm();
            buttonCreate();
            buttonEdit();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    AssetsList.init();
});
