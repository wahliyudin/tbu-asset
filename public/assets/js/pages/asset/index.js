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

    var attributes = {
        key: '',
        kode: '',
        unit_id: '',
        sub_cluster_id: '',
        member_name: '',
        pic: '',
        activity: '',
        asset_location: '',
        kondisi: '',
        uom: '',
        quantity: '',
        tgl_bast: '',
        hm: '',
        pr_number: '',
        po_number: '',
        gr_number: '',
        remark: '',
        status: '',

        dealer_id_leasing: '',
        leasing_id_leasing: '',
        harga_beli_leasing: '',
        jangka_waktu_leasing: '',
        biaya_leasing: '',
        legalitas_leasing: '',

        jangka_waktu_insurance: '',
        biaya_insurance: '',
        legalitas_insurance: '',
    };

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

    var initPlugins = () => {
        $("#tgl_bast").flatpickr();
        $('.uang').mask('0.000.000.000', {
            reverse: true
        });
    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-asset-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
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

                    'dealer_id_leasing': {
                        validators: {
                            notEmpty: {
                                message: 'Dealer is required'
                            }
                        }
                    },
                    'leasing_id_leasing': {
                        validators: {
                            notEmpty: {
                                message: 'Leasing is required'
                            }
                        }
                    },
                    'harga_beli_leasing': {
                        validators: {
                            notEmpty: {
                                message: 'Harga Beli is required'
                            }
                        }
                    },
                    'jangka_waktu_leasing': {
                        validators: {
                            notEmpty: {
                                message: 'Jangka Waktu is required'
                            }
                        }
                    },
                    'biaya_leasing': {
                        validators: {
                            notEmpty: {
                                message: 'Biaya is required'
                            }
                        }
                    },
                    'legalitas_leasing': {
                        validators: {
                            notEmpty: {
                                message: 'Legalitas is required'
                            }
                        }
                    },

                    'jangka_waktu_insurance': {
                        validators: {
                            notEmpty: {
                                message: 'Jangka Waktu is required'
                            }
                        }
                    },
                    'biaya_insurance': {
                        validators: {
                            notEmpty: {
                                message: 'Biaya is required'
                            }
                        }
                    },
                    'legalitas_insurance': {
                        validators: {
                            notEmpty: {
                                message: 'Legalitas is required'
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
                        fillAttributes();
                        $.ajax({
                            type: "POST",
                            url: "/asset-masters/store",
                            data: attributes,
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

    const fillAttributes = () => {
        attributes.key = $(submitButton).data('asset');
        attributes.kode = $($(form).find('input[name="kode"]')).val();
        attributes.unit_id = $($(form).find('select[name="unit_id"]')).val();
        attributes.sub_cluster_id = $($(form).find('select[name="sub_cluster_id"]')).val();
        attributes.member_name = $($(form).find('input[name="member_name"]')).val();
        attributes.pic = $($(form).find('input[name="pic"]')).val();
        attributes.activity = $($(form).find('input[name="activity"]')).val();
        attributes.asset_location = $($(form).find('input[name="asset_location"]')).val();
        attributes.kondisi = $($(form).find('input[name="kondisi"]')).val();
        attributes.uom = $($(form).find('input[name="uom"]')).val();
        attributes.quantity = $($(form).find('input[name="quantity"]')).val();
        attributes.tgl_bast = $($(form).find('input[name="tgl_bast"]')).val();
        attributes.hm = $($(form).find('input[name="hm"]')).val();
        attributes.pr_number = $($(form).find('input[name="pr_number"]')).val();
        attributes.po_number = $($(form).find('input[name="po_number"]')).val();
        attributes.gr_number = $($(form).find('input[name="gr_number"]')).val();
        attributes.remark = $($(form).find('input[name="remark"]')).val();
        attributes.status = $($(form).find('select[name="status"]')).val();

        attributes.dealer_id_leasing = $($(form).find('select[name="dealer_id_leasing"]')).val();
        attributes.leasing_id_leasing = $($(form).find('select[name="leasing_id_leasing"]')).val();
        attributes.harga_beli_leasing = $($(form).find('input[name="harga_beli_leasing"]')).val();
        attributes.jangka_waktu_leasing = $($(form).find('input[name="jangka_waktu_leasing"]')).val();
        attributes.biaya_leasing = $($(form).find('input[name="biaya_leasing"]')).val();
        attributes.legalitas_leasing = $($(form).find('input[name="legalitas_leasing"]')).val();

        attributes.jangka_waktu_insurance = $($(form).find('input[name="jangka_waktu_insurance"]')).val();
        attributes.biaya_insurance = $($(form).find('input[name="biaya_insurance"]')).val();
        attributes.legalitas_insurance = $($(form).find('input[name="legalitas_insurance"]')).val();
    }

    var resetAttributes = () => {
        attributes.key = '';
        attributes.kode = '';
        attributes.unit_id = '';
        attributes.sub_cluster_id = '';
        attributes.member_name = '';
        attributes.pic = '';
        attributes.activity = '';
        attributes.asset_location = '';
        attributes.kondisi = '';
        attributes.uom = '';
        attributes.quantity = '';
        attributes.tgl_bast = '';
        attributes.hm = '';
        attributes.pr_number = '';
        attributes.po_number = '';
        attributes.gr_number = '';
        attributes.remark = '';
        attributes.status = '';

        attributes.dealer_id_leasing = '';
        attributes.leasing_id_leasing = '';
        attributes.harga_beli_leasing = '';
        attributes.jangka_waktu_leasing = '';
        attributes.biaya_leasing = '';
        attributes.legalitas_leasing = '';

        attributes.jangka_waktu_insurance = '';
        attributes.biaya_insurance = '';
        attributes.legalitas_insurance = '';
    }

    const populateForm = (json = null) => {
        $($(form).find('input[name="kode"]')).val(json === null ? attributes.kode : json.kode);
        $($(form).find('select[name="unit_id"]')).val(json === null ? attributes.unit_id : json.unit_id).trigger('change');
        $($(form).find('select[name="sub_cluster_id"]')).val(json === null ? attributes.sub_cluster_id : json.sub_cluster_id).trigger('change');
        $($(form).find('input[name="member_name"]')).val(json === null ? attributes.member_name : json.member_name);
        $($(form).find('input[name="pic"]')).val(json === null ? attributes.pic : json.pic);
        $($(form).find('input[name="activity"]')).val(json === null ? attributes.activity : json.activity);
        $($(form).find('input[name="asset_location"]')).val(json === null ? attributes.asset_location : json.asset_location);
        $($(form).find('input[name="kondisi"]')).val(json === null ? attributes.kondisi : json.kondisi);
        $($(form).find('input[name="uom"]')).val(json === null ? attributes.uom : json.uom);
        $($(form).find('input[name="quantity"]')).val(json === null ? attributes.quantity : json.quantity);
        $($(form).find('input[name="tgl_bast"]')).val(json === null ? attributes.tgl_bast : json.tgl_bast);
        $($(form).find('input[name="hm"]')).val(json === null ? attributes.hm : json.hm);
        $($(form).find('input[name="pr_number"]')).val(json === null ? attributes.pr_number : json.pr_number);
        $($(form).find('input[name="po_number"]')).val(json === null ? attributes.po_number : json.po_number);
        $($(form).find('input[name="gr_number"]')).val(json === null ? attributes.gr_number : json.gr_number);
        $($(form).find('input[name="remark"]')).val(json === null ? attributes.remark : json.remark);
        $($(form).find('select[name="status"]')).val(json === null ? attributes.status : json.status).trigger('change');

        $($(form).find('select[name="dealer_id_leasing"]')).val(json === null ? attributes.dealer_id_leasing : json.leasing?.dealer_id).trigger('change');
        $($(form).find('select[name="leasing_id_leasing"]')).val(json === null ? attributes.leasing_id_leasing : json.leasing?.leasing_id).trigger('change');
        $($(form).find('input[name="harga_beli_leasing"]')).val(json === null ? attributes.harga_beli_leasing : json.leasing?.harga_beli).trigger('input');
        $($(form).find('input[name="jangka_waktu_leasing"]')).val(json === null ? attributes.jangka_waktu_leasing : json.leasing?.jangka_waktu);
        $($(form).find('input[name="biaya_leasing"]')).val(json === null ? attributes.biaya_leasing : json.leasing?.biaya).trigger('input');
        $($(form).find('input[name="legalitas_leasing"]')).val(json === null ? attributes.legalitas_leasing : json.leasing?.legalitas);

        $($(form).find('input[name="jangka_waktu_insurance"]')).val(json === null ? attributes.jangka_waktu_insurance : json.insurance?.jangka_waktu);
        $($(form).find('input[name="biaya_insurance"]')).val(json === null ? attributes.biaya_insurance : json.insurance?.biaya).trigger('input');
        $($(form).find('input[name="legalitas_insurance"]')).val(json === null ? attributes.legalitas_insurance : json.insurance?.legalitas);
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
            resetAttributes();
            populateForm();
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
                    populateForm(response);
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


            var modalElement = document.querySelector('#create-asset');
            modal = new bootstrap.Modal(modalElement);
            form = document.querySelector('#create-asset_form');
            submitButton = modalElement.querySelector('#create-asset_submit');
            cancelButton = modalElement.querySelector('#create-asset_cancel');
            closeButton = modalElement.querySelector('#create-asset_close');

            handleForm();
            buttonCreate();
            buttonEdit();
            initPlugins();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    AssetsList.init();
});
