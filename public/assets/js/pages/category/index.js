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
                url: "/master/categories/datatable"
            },
            columns: [
                {
                    name: 'name',
                    data: 'name',
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
        const filterSearch = document.querySelector('[data-kt-category-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    var handleDeleteRow = () => {
        $('#category_table').on('click', '.btn-delete', function () {
            var category = $(this).data('category');
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
                        url: `/master/categories/${category}/destroy`,
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
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Category name is required'
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
                            url: "/master/categories/store",
                            data: {
                                key: $(submitButton).data('category'),
                                name: $($(form).find('input[name="name"]')).val(),
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
        $('[data-bs-target="#create-category"]').on('click', function () {
            $($(form).find('input[name="name"]')).val('');
            $(submitButton).data('category', '');
        });
    }

    var buttonEdit = () => {
        $('#category_table').on('click', '.btn-edit', function () {
            var target = this;
            $(target).attr("data-kt-indicator", "on");
            var category = $(this).data('category');
            $(submitButton).data('category', category);
            $.ajax({
                type: "POST",
                url: `/master/categories/${category}/edit`,
                dataType: "JSON",
                success: function (response) {
                    $($(form).find('input[name="name"]')).val(response.name);
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
            table = document.querySelector('#category_table');
            if (!table) {
                return;
            }
            initCategoryList();
            handleSearchDatatable();
            handleDeleteRow();


            modal = new bootstrap.Modal(document.querySelector('#create-category'));
            form = document.querySelector('#create-category_form');
            submitButton = form.querySelector('#create-category_submit');
            cancelButton = form.querySelector('#create-category_cancel');
            closeButton = form.querySelector('#create-category_close');

            handleForm();
            buttonCreate();
            buttonEdit();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    CategorysList.init();
});
