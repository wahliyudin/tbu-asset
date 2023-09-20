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
    var modalImport;

    var attributes = {
        key: '',
        kode: '',
        unit_id: '',
        sub_cluster_id: '',
        pic: '',
        activity: '',
        asset_location: '',
        kondisi: '',
        uom_id: '',
        quantity: '',
        tgl_bast: '',
        hm: '',
        pr_number: '',
        po_number: '',
        gr_number: '',
        remark: '',
        status: '',

        unit_unit_id: '',
        unit_kode: '',
        unit_type: '',
        unit_seri: '',
        unit_class: '',
        unit_brand: '',
        unit_serial_number: '',
        unit_spesification: '',
        unit_tahun_pembuatan: '',
        unit_kelengkapan_tambahan: '',

        dealer_id_leasing: '',
        leasing_id_leasing: '',
        harga_beli_leasing: '',
        jangka_waktu_leasing: '',
        biaya_leasing: '',
        legalitas_leasing: '',
        tanggal_perolehan_leasing: '',

        jangka_waktu_insurance: '',
        biaya_insurance: '',
        legalitas_insurance: '',

        umur_asset: '',
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
            // serverSide: true,
            order: [[0, 'asc']],
            ajax: {
                type: "POST",
                url: "/asset-masters/datatable",
                data: function (d) {
                    d.search = $('input[name="search"]').val();
                }
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
        // $("#tgl_bast").flatpickr();
        // $("#tanggal_perolehan_leasing").flatpickr();
        // $('.uang').mask('0.000.000.000', {
        //     reverse: true
        // });
        // new tempusDominus.TempusDominus(document.getElementById("tahun_pembuatan"), {
        //     display: {
        //         viewMode: "calendar",
        //         components: {
        //             decades: true,
        //             year: true,
        //             month: false,
        //             date: false,
        //             hours: false,
        //             minutes: false,
        //             seconds: false
        //         }
        //     },
        //     localization: {
        //         format: 'yyyy'
        //     }
        // });
    }

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-asset-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            // datatable.search(e.target.value).draw();
            datatable.ajax.reload();
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
                    // 'pic': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'PIC is required'
                    //         }
                    //     }
                    // },
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
                    'uom_id': {
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
                    // 'hm': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'HM is required'
                    //         }
                    //     }
                    // },
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

                    'unit_unit_id': {
                        validators: {
                            notEmpty: {
                                message: 'Unit is required'
                            }
                        }
                    },
                    'unit_kode': {
                        validators: {
                            notEmpty: {
                                message: 'Kode is required'
                            }
                        }
                    },
                    'unit_model': {
                        validators: {
                            notEmpty: {
                                message: 'Model is required'
                            }
                        }
                    },
                    'unit_type': {
                        validators: {
                            notEmpty: {
                                message: 'Type is required'
                            }
                        }
                    },
                    'unit_seri': {
                        validators: {
                            notEmpty: {
                                message: 'Seri is required'
                            }
                        }
                    },
                    'unit_class': {
                        validators: {
                            notEmpty: {
                                message: 'Class is required'
                            }
                        }
                    },
                    'unit_brand': {
                        validators: {
                            notEmpty: {
                                message: 'Brand is required'
                            }
                        }
                    },
                    'unit_serial_number': {
                        validators: {
                            notEmpty: {
                                message: 'Status is required'
                            }
                        }
                    },
                    'unit_spesification': {
                        validators: {
                            notEmpty: {
                                message: 'Spesification is required'
                            }
                        }
                    },
                    'unit_kelengkapan_tambahan': {
                        validators: {
                            notEmpty: {
                                message: 'Kelengkapan Tambahan is required'
                            }
                        }
                    },
                    'unit_tahun_pembuatan': {
                        validators: {
                            notEmpty: {
                                message: 'Tahun Pembuatan is required'
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
                    'tanggal_perolehan_leasing': {
                        validators: {
                            notEmpty: {
                                message: 'Tanggal Perolehan is required'
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

                    'umur_asset': {
                        validators: {
                            notEmpty: {
                                message: 'Umur Asset is required'
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
                                        submitButton.disabled = false;
                                        datatable.ajax.reload();
                                        modal.hide();
                                    }
                                });
                            },
                            error: function (jqXHR) {
                                handleError(jqXHR, submitButton);
                            }
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
        attributes.pic = $($(form).find('select[name="pic"]')).val();
        attributes.activity = $($(form).find('input[name="activity"]')).val();
        attributes.asset_location = $($(form).find('select[name="asset_location"]')).val();
        attributes.kondisi = $($(form).find('input[name="kondisi"]')).val();
        attributes.uom_id = $($(form).find('select[name="uom_id"]')).val();
        attributes.quantity = $($(form).find('input[name="quantity"]')).val();
        attributes.tgl_bast = $($(form).find('input[name="tgl_bast"]')).val();
        attributes.hm = $($(form).find('input[name="hm"]')).val();
        attributes.pr_number = $($(form).find('input[name="pr_number"]')).val();
        attributes.po_number = $($(form).find('input[name="po_number"]')).val();
        attributes.gr_number = $($(form).find('input[name="gr_number"]')).val();
        attributes.remark = $($(form).find('input[name="remark"]')).val();
        attributes.status = $($(form).find('select[name="status"]')).val();

        attributes.unit_unit_id = $($(form).find('select[name="unit_unit_id"]')).val();
        attributes.unit_kode = $($(form).find('input[name="unit_kode"]')).val();
        attributes.unit_type = $($(form).find('input[name="unit_type"]')).val();
        attributes.unit_seri = $($(form).find('input[name="unit_seri"]')).val();
        attributes.unit_class = $($(form).find('input[name="unit_class"]')).val();
        attributes.unit_brand = $($(form).find('input[name="unit_brand"]')).val();
        attributes.unit_serial_number = $($(form).find('input[name="unit_serial_number"]')).val();
        attributes.unit_spesification = $($(form).find('input[name="unit_spesification"]')).val();
        attributes.unit_tahun_pembuatan = $($(form).find('input[name="unit_tahun_pembuatan"]')).val();
        attributes.unit_kelengkapan_tambahan = $($(form).find('input[name="unit_kelengkapan_tambahan"]')).val();

        attributes.dealer_id_leasing = $($(form).find('select[name="dealer_id_leasing"]')).val();
        attributes.leasing_id_leasing = $($(form).find('select[name="leasing_id_leasing"]')).val();
        attributes.harga_beli_leasing = $($(form).find('input[name="harga_beli_leasing"]')).val();
        attributes.jangka_waktu_leasing = $($(form).find('input[name="jangka_waktu_leasing"]')).val();
        attributes.biaya_leasing = $($(form).find('input[name="biaya_leasing"]')).val();
        attributes.legalitas_leasing = $($(form).find('input[name="legalitas_leasing"]')).val();
        attributes.tanggal_perolehan_leasing = $($(form).find('input[name="tanggal_perolehan_leasing"]')).val();

        attributes.jangka_waktu_insurance = $($(form).find('input[name="jangka_waktu_insurance"]')).val();
        attributes.biaya_insurance = $($(form).find('input[name="biaya_insurance"]')).val();
        attributes.legalitas_insurance = $($(form).find('input[name="legalitas_insurance"]')).val();

        attributes.umur_asset = $($(form).find('input[name="umur_asset"]')).val();
    }

    var resetAttributes = () => {
        attributes.key = '';
        attributes.kode = '';
        attributes.unit_id = '';
        attributes.sub_cluster_id = '';
        attributes.pic = '';
        attributes.activity = '';
        attributes.asset_location = '';
        attributes.kondisi = '';
        attributes.uom_id = '';
        attributes.quantity = '';
        attributes.tgl_bast = '';
        attributes.hm = '';
        attributes.pr_number = '';
        attributes.po_number = '';
        attributes.gr_number = '';
        attributes.remark = '';
        attributes.status = '';

        attributes.unit_unit_id = '';
        attributes.unit_kode = '';
        attributes.unit_type = '';
        attributes.unit_seri = '';
        attributes.unit_class = '';
        attributes.unit_brand = '';
        attributes.unit_serial_number = '';
        attributes.unit_spesification = '';
        attributes.unit_tahun_pembuatan = '';
        attributes.unit_kelengkapan_tambahan = '';

        attributes.dealer_id_leasing = '';
        attributes.leasing_id_leasing = '';
        attributes.harga_beli_leasing = '';
        attributes.jangka_waktu_leasing = '';
        attributes.biaya_leasing = '';
        attributes.legalitas_leasing = '';
        attributes.tanggal_perolehan_leasing = '';

        attributes.jangka_waktu_insurance = '';
        attributes.biaya_insurance = '';
        attributes.legalitas_insurance = '';

        attributes.umur_asset = '';
    }

    const populateForm = (json = null) => {
        $($(form).find('input[name="kode"]')).val(json === null ? attributes.kode : json.kode);
        $($(form).find('select[name="unit_id"]')).val(json === null ? attributes.unit_id : json.unit_id).trigger('change');
        $($(form).find('select[name="sub_cluster_id"]')).val(json === null ? attributes.sub_cluster_id : json.sub_cluster_id).trigger('change');
        $($(form).find('select[name="pic"]')).val(json === null ? attributes.pic : json.pic).trigger('change');
        $($(form).find('input[name="activity"]')).val(json === null ? attributes.activity : json.activity);
        $($(form).find('select[name="asset_location"]')).val(json === null ? attributes.asset_location : json.asset_location).trigger('change');
        $($(form).find('input[name="kondisi"]')).val(json === null ? attributes.kondisi : json.kondisi);
        $($(form).find('select[name="uom_id"]')).val(json === null ? attributes.uom_id : json.uom_id).trigger('change');
        $($(form).find('input[name="quantity"]')).val(json === null ? attributes.quantity : json.quantity);
        $($(form).find('input[name="tgl_bast"]')).val(json === null ? attributes.tgl_bast : json.tgl_bast);
        $($(form).find('input[name="hm"]')).val(json === null ? attributes.hm : json.hm);
        $($(form).find('input[name="pr_number"]')).val(json === null ? attributes.pr_number : json.pr_number);
        $($(form).find('input[name="po_number"]')).val(json === null ? attributes.po_number : json.po_number);
        $($(form).find('input[name="gr_number"]')).val(json === null ? attributes.gr_number : json.gr_number);
        $($(form).find('input[name="remark"]')).val(json === null ? attributes.remark : json.remark);
        $($(form).find('select[name="status"]')).val(json === null ? attributes.status : json.status).trigger('change');

        $($(form).find('select[name="unit_unit_id"]')).val(json === null ? attributes.unit_unit_id : json.asset_unit?.unit_id).trigger('change');
        $($(form).find('input[name="unit_kode"]')).val(json === null ? attributes.unit_kode : json.asset_unit?.kode);
        $($(form).find('input[name="unit_type"]')).val(json === null ? attributes.unit_type : json.asset_unit?.type);
        $($(form).find('input[name="unit_seri"]')).val(json === null ? attributes.unit_seri : json.asset_unit?.seri);
        $($(form).find('input[name="unit_class"]')).val(json === null ? attributes.unit_class : json.asset_unit?.class);
        $($(form).find('input[name="unit_brand"]')).val(json === null ? attributes.unit_brand : json.asset_unit?.brand);
        $($(form).find('input[name="unit_serial_number"]')).val(json === null ? attributes.unit_serial_number : json.asset_unit?.serial_number);
        $($(form).find('input[name="unit_spesification"]')).val(json === null ? attributes.unit_spesification : json.asset_unit?.spesification);
        $($(form).find('input[name="unit_tahun_pembuatan"]')).val(json === null ? attributes.unit_tahun_pembuatan : json.asset_unit?.tahun_pembuatan);
        $($(form).find('input[name="unit_kelengkapan_tambahan"]')).val(json === null ? attributes.unit_kelengkapan_tambahan : json.asset_unit?.kelengkapan_tambahan);

        $($(form).find('select[name="dealer_id_leasing"]')).val(json === null ? attributes.dealer_id_leasing : json.leasing?.dealer_id).trigger('change');
        $($(form).find('select[name="leasing_id_leasing"]')).val(json === null ? attributes.leasing_id_leasing : json.leasing?.leasing_id).trigger('change');
        $($(form).find('input[name="harga_beli_leasing"]')).val(json === null ? attributes.harga_beli_leasing : json.leasing?.harga_beli).trigger('input');
        $($(form).find('input[name="jangka_waktu_leasing"]')).val(json === null ? attributes.jangka_waktu_leasing : json.leasing?.jangka_waktu_leasing);
        $($(form).find('input[name="biaya_leasing"]')).val(json === null ? attributes.biaya_leasing : json.leasing?.biaya_leasing).trigger('input');
        $($(form).find('input[name="legalitas_leasing"]')).val(json === null ? attributes.legalitas_leasing : json.leasing?.legalitas);
        $($(form).find('input[name="tanggal_perolehan_leasing"]')).val(json === null ? attributes.tanggal_perolehan_leasing : json.leasing?.tanggal_perolehan);

        $($(form).find('input[name="jangka_waktu_insurance"]')).val(json === null ? attributes.jangka_waktu_insurance : json.insurance?.jangka_waktu);
        $($(form).find('input[name="biaya_insurance"]')).val(json === null ? attributes.biaya_insurance : json.insurance?.biaya).trigger('input');
        $($(form).find('input[name="legalitas_insurance"]')).val(json === null ? attributes.legalitas_insurance : json.insurance?.legalitas);

        $($(form).find('input[name="price"]')).val(json === null ? attributes.harga_beli_leasing : json.leasing?.harga_beli).trigger('input');
        $($(form).find('input[name="date"]')).val(json === null ? attributes.tgl_bast : json.tgl_bast);
        $($(form).find('input[name="umur_asset"]')).val(json === null ? attributes.umur_asset : json.umur_asset).trigger('change');
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
        $('[data-bs-target="#create-asset"]').on('click', function () {
            resetAttributes();
            populateForm();
            $('#create-asset .title').text('Tambah Asset');
            $(submitButton).data('asset', '');
        });
    }

    var buttonEdit = () => {
        $('#asset_table').on('click', '.btn-edit', function () {
            var target = this;
            $(target).attr("data-kt-indicator", "on");
            $('#create-asset .title').text('Edit Asset');
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
                error: function (jqXHR) {
                    handleError(jqXHR, target);
                }
            });
        });
    }

    var formImport = () => {
        $('#import-asset_submit').click(function (e) {
            e.preventDefault();
            var submitBtn = $('#import-asset_submit');
            var postData = new FormData($(`#import-asset_form`)[0]);
            submitBtn.attr("data-kt-indicator", "on");
            $.ajax({
                type: 'POST',
                url: "/asset-masters/import",
                processData: false,
                contentType: false,
                data: postData,
                success: function (response) {
                    submitBtn.removeAttr('data-kt-indicator');
                    $('input[name="file"]').val('');
                    modalImport.hide();
                    $('.notif-progress').removeClass('d-none');
                    localStorage.setItem('message_asset', 'Successfully imported');
                    $('.notif-progress #title').text('Uploading...');
                    localStorage.setItem('is_bulk', 0);
                    localStorage.setItem('batch_asset', response.id);
                },
                error: function (jqXHR) {
                    handleError(jqXHR, submitBtn);
                }
            });
        });
    }

    var initInterval = () => {
        $('.btn-sync-progress').click(function (e) {
            e.preventDefault();
            $(this).attr('disabled', true);
            localStorage.removeItem('batch_asset');
            bulkProcess();
        });
        $('.btn-close-progress').click(function (e) {
            e.preventDefault();
            $('.notif-progress-line').width('0%');
            $('.notif-progress-line').text('0%');
            $('.notif-progress').addClass('d-none');
            localStorage.removeItem('batch_asset');
            localStorage.removeItem('batch_asset_bulk');
        });
        setInterval(() => {
            var batch_asset = localStorage.getItem('batch_asset');
            var batch_asset_bulk = localStorage.getItem('batch_asset_bulk');
            var batch_asset_success = parseInt(localStorage.getItem('batch_asset_success'));
            var batch_asset_failed = parseInt(localStorage.getItem('batch_asset_failed'));
            var batch_asset_total = parseInt(localStorage.getItem('batch_asset_total'));
            var total = batch_asset_failed + batch_asset_success;

            if (batch_asset || batch_asset_bulk) {
                if ($('.notif-progress').hasClass('d-none')) {
                    $('.notif-progress').removeClass('d-none');
                }
                if (batch_asset_bulk && !batch_asset) {
                    $('.btn-sync-progress').attr('disabled', true);
                }
                if (!batch_asset_bulk && batch_asset && total == batch_asset_total) {
                    $('.btn-sync-progress').attr('disabled', false);
                }
                fetchBatch(batch_asset ?? batch_asset_bulk)
                    .then(function (response) {
                        $('.notif-progress-line').width(response.progress + '%');
                        $('.notif-progress-line').text(response.progress + '%');
                        // if (response.progress == 100) {
                        //     $('.notif-progress-line').width('0%');
                        //     $('.notif-progress-line').text('0%');
                        //     datatable.ajax.reload();
                        //     $('.notif-progress').addClass('d-none');
                        //     localStorage.removeItem('batch_asset');
                        //     toastr.options.closeButton = true;
                        //     toastr.options.timeOut = 1000000;
                        //     toastr.options.extendedTimeOut = 1000000;
                        //     toastr.success(localStorage.getItem('message_asset'), 'Completed!');
                        // }

                        localStorage.setItem('batch_asset_success', response.processedJobs);
                        localStorage.setItem('batch_asset_failed', response.failedJobs);
                        localStorage.setItem('batch_asset_total', response.totalJobs);

                        // if (response.failedJobs > 0) {
                        // $('.notif-progress-line').width('0%');
                        // $('.notif-progress-line').text('0%');
                        // datatable.ajax.reload();
                        // $('.notif-progress').addClass('d-none');
                        // localStorage.removeItem('batch_asset');
                        // toastr.options.closeButton = true;
                        // toastr.options.timeOut = 1000000;
                        // toastr.options.extendedTimeOut = 1000000;
                        // var message = "Jumlah Job gagal: " + response.failedJobs + "<br> Jumlah Job sukses: " + response.processedJobs + "<br> dari " + response.totalJobs + " Job";
                        // toastr.error(message, 'Gagal!');
                        // }
                        if (batch_asset_bulk) {
                            $('.notif-progress #title').text('Synchronize...');
                        }
                        if (batch_asset) {
                            $('.notif-progress #title').text('Uploading...');
                        }
                        $('.notif-progress #desc').text(`Success: ${response.processedJobs}, Failed: ${response.failedJobs}, From: ${response.totalJobs}`);
                    })
                    .catch(function (error) {
                        handleError(error);
                    });
            }
        }, 1000);
    }

    var fetchBatch = (batch_asset) => {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: "POST",
                url: "/asset-masters/batch",
                data: {
                    id: batch_asset
                },
                dataType: "JSON",
                success: function (response) {
                    resolve(response);
                },
                error: function (error) {
                    reject(error);
                }
            });
        });
    }

    var fetchBulk = () => {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: "POST",
                url: "/asset-masters/bulk",
                dataType: "JSON",
                success: function (response) {
                    resolve(response);
                },
                error: function (error) {
                    reject(error);
                }
            });
        });
    }

    var bulkProcess = () => {
        fetchBulk()
            .then(function (response) {
                $('.notif-progress #title').text('Synchronize...');
                localStorage.setItem('batch_asset_bulk', response.id);
                localStorage.setItem('message_asset', "Successfully synchronize");
            })
            .catch(function (error) {
                handleError(error);
                $(this).attr('disabled', false);
            });
    }

    var toast = (code, title, message) => {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1000000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        switch (code) {
            case 200:
                toastr.success(title, message);
                break;

            default:
                toastr.error(title, message);
                break;
        }
    }

    // var initEvent = () => {
    //     window.Echo.channel('coba-channel')
    //         .listen('.import-event', (e) => {
    //             toast(e.status, e.title, e.message);
    //         });
    // }

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
            var modalImportElemnt = document.querySelector('#import-asset');
            modal = new bootstrap.Modal(modalElement);
            modalImport = new bootstrap.Modal(modalImportElemnt);
            form = document.querySelector('#create-asset_form');
            submitButton = modalElement.querySelector('#create-asset_submit');
            cancelButton = modalElement.querySelector('#create-asset_cancel');
            closeButton = modalElement.querySelector('#create-asset_close');

            handleForm();
            buttonCreate();
            buttonEdit();
            initPlugins();
            formImport();
            // initEvent();

            $('#import-asset').on('hidden.bs.modal', function (e) {
                $('.modal-backdrop').remove(); // Menghapus backdrop secara manual
            });

            initInterval();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    AssetsList.init();
});
