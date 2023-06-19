"use strict";

var CategorysList = function () {
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
                url: "/master/units/datatable"
            },
            columns: [
                {
                    name: 'model',
                    data: 'model',
                },
                {
                    name: 'type',
                    data: 'type',
                },
                {
                    name: 'seri',
                    data: 'seri',
                },
                {
                    name: 'class',
                    data: 'class',
                },
                {
                    name: 'brand',
                    data: 'brand',
                },
                {
                    name: 'serial_number',
                    data: 'serial_number',
                },
                {
                    name: 'spesification',
                    data: 'spesification',
                },
                {
                    name: 'tahun_pembuatan',
                    data: 'tahun_pembuatan',
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
        const filterSearch = document.querySelector('[data-kt-unit-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    var handleDeleteRow = () => {
        $('#unit_table').on('click', '.btn-delete', function () {
            var unit = $(this).data('unit');
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
                        url: `/master/units/${unit}/destroy`,
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
                    'model': {
                        validators: {
                            notEmpty: {
                                message: 'Model is required'
                            }
                        }
                    },
                    'type': {
                        validators: {
                            notEmpty: {
                                message: 'Type is required'
                            }
                        }
                    },
                    'seri': {
                        validators: {
                            notEmpty: {
                                message: 'Seri is required'
                            }
                        }
                    },
                    'class': {
                        validators: {
                            notEmpty: {
                                message: 'Class is required'
                            }
                        }
                    },
                    'brand': {
                        validators: {
                            notEmpty: {
                                message: 'Brand is required'
                            }
                        }
                    },
                    'serial_number': {
                        validators: {
                            notEmpty: {
                                message: 'Serial Number is required'
                            }
                        }
                    },
                    'spesification': {
                        validators: {
                            notEmpty: {
                                message: 'Spesification is required'
                            }
                        }
                    },
                    'tahun_pembuatan': {
                        validators: {
                            notEmpty: {
                                message: 'Tahun Pembuatan is required'
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
                            url: "/master/units/store",
                            data: {
                                key: $(submitButton).data('unit'),
                                model: $($(form).find('input[name="model"]')).val(),
                                type: $($(form).find('input[name="type"]')).val(),
                                seri: $($(form).find('input[name="seri"]')).val(),
                                class: $($(form).find('input[name="class"]')).val(),
                                brand: $($(form).find('input[name="brand"]')).val(),
                                serial_number: $($(form).find('input[name="serial_number"]')).val(),
                                spesification: $($(form).find('input[name="spesification"]')).val(),
                                tahun_pembuatan: $($(form).find('input[name="tahun_pembuatan"]')).val(),
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
        $('[data-bs-target="#create-unit"]').on('click', function () {
            $($(form).find('input[name="model"]')).val('');
            $($(form).find('input[name="type"]')).val('');
            $($(form).find('input[name="seri"]')).val('');
            $($(form).find('input[name="class"]')).val('');
            $($(form).find('input[name="brand"]')).val('');
            $($(form).find('input[name="serial_number"]')).val('');
            $($(form).find('input[name="spesification"]')).val('');
            $($(form).find('input[name="tahun_pembuatan"]')).val('');
            $(submitButton).data('unit', '');
        });
    }

    var buttonEdit = () => {
        $('#unit_table').on('click', '.btn-edit', function () {
            var target = this;
            $(target).attr("data-kt-indicator", "on");
            var unit = $(this).data('unit');
            $(submitButton).data('unit', unit);
            $.ajax({
                type: "POST",
                url: `/master/units/${unit}/edit`,
                dataType: "JSON",
                success: function (response) {
                    $($(form).find('input[name="model"]')).val(response.model);
                    $($(form).find('input[name="type"]')).val(response.type);
                    $($(form).find('input[name="seri"]')).val(response.seri);
                    $($(form).find('input[name="class"]')).val(response.class);
                    $($(form).find('input[name="brand"]')).val(response.brand);
                    $($(form).find('input[name="serial_number"]')).val(response.serial_number);
                    $($(form).find('input[name="spesification"]')).val(response.spesification);
                    $($(form).find('input[name="tahun_pembuatan"]')).val(response.tahun_pembuatan);
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
            table = document.querySelector('#unit_table');
            if (!table) {
                return;
            }
            initCategoryList();
            handleSearchDatatable();
            handleDeleteRow();


            modal = new bootstrap.Modal(document.querySelector('#create-unit'));
            form = document.querySelector('#create-unit_form');
            submitButton = form.querySelector('#create-unit_submit');
            cancelButton = form.querySelector('#create-unit_cancel');
            closeButton = form.querySelector('#create-unit_close');

            handleForm();
            buttonCreate();
            buttonEdit();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    CategorysList.init();
});
