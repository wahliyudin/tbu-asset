"use strict";

var KTModalCersAdd = function () {
    var datatableAsset;
    var datatableBudget;
    var modalAsset;
    var modalBudget;
    var currentItem;

    var initRepeater = () => {
        $('.items').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function () {
                $(this).slideDown();
                currentItem = this;
                $(this).find('.qty').val(1);
                initPluginsAndEventRepeater();
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
                initPluginsAndEventRepeater();
                initTotalRepeater(numberFromString($(this).find('.sub-total').val()));
            },
            ready: function () {
            },
            isFirstItemUndeletable: true
        });
        initPluginsAndEventRepeater();
        currentItem = $('[data-repeater-item]').get(0);
    }

    var initPluginsAndEventRepeater = () => {
        $('.uang').mask('0.000.000.000', {
            reverse: true
        });
        $('.qty').each(function (index, element) {
            $(element).change(function (e) {
                var qty = $(element).val();
                var tr = $(element).parent().parent();
                var price = numberFromString($(tr).find('.price').val());
                var subTotal = qty * price;
                $(tr).find('.sub-total').val(subTotal).trigger('input');
                initTotalRepeater();
            });
        });
        $('.price').each(function (index, element) {
            $(element).keyup(function (e) {
                var tr = $(element).parent().parent();
                var qty = $(tr).find('.qty').val();
                var price = numberFromString($(element).val());
                var subTotal = qty * price;
                $(tr).find('.sub-total').val(subTotal).trigger('input');
                initTotalRepeater();
            });
        });
        $('[data-repeater-list="items"]').on('click', '[btn-asset]', function (e) {
            e.preventDefault();
            modalAsset.show();
            currentItem = $(this).closest('tr');
        });
    }

    var initTotalRepeater = (number = 0) => {
        var total = 0;
        $('.sub-total').each(function (index, element) {
            total += numberFromString($(element).val());
        });
        $('input[name="total_idr"]').val(total - number).trigger('input');
    }

    var initPlugins = () => {
        $(".date").flatpickr();
    }

    var initDatatableBudget = () => {
        datatableBudget = $('#data-budget_table').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [1, 'asc']
            ],
            ajax: {
                type: "POST",
                url: "/budgets/datatable",
                data: {
                    'deptcode': $('input[name="deptcode"').val()
                }
            },
            columns: [{
                name: 'action',
                data: 'action',
                orderable: false,
                searchable: false
            },
            {
                name: 'kode',
                data: 'kode',
            },
            {
                name: 'periode',
                data: 'periode',
            },
            {
                name: 'description',
                data: 'description',
            },
            {
                name: 'total',
                data: 'total',
            },],
        });

        const filterSearch = document.querySelector('[data-kt-data-budget-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            datatableBudget.search(e.target.value).draw();
        });

        initActionBudget();
    }

    var initActionBudget = () => {
        $('.search-budget').click(function (e) {
            e.preventDefault();
            modalBudget.show();
        });
        $('#data_budget').on('click', '.select-budget', function (e) {
            e.preventDefault();
            var budget = $(this).data('budget');
            const parent = e.target.closest('tr');
            var arrayTd = parent.querySelectorAll('td');
            populateBudget(arrayTd);
            modalBudget.hide();
        });
    }

    var populateBudget = (arrayTd) => {
        $('input[name="budget_ref"]').val(arrayTd[1].innerText);
        $('input[name="budget_periode"]').val(arrayTd[2].innerText);
        $('input[name="total_budget_idr"]').val(arrayTd[3].innerText);
    }

    var initDatatableAsset = () => {
        datatableAsset = $('#data-asset_table').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [1, 'asc']
            ],
            ajax: {
                type: "POST",
                url: "/asset-requests/datatable-asset-idle"
            },
            columns: [{
                name: 'action',
                data: 'action',
                orderable: false,
                searchable: false
            },
            {
                name: 'kode',
                data: 'kode',
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
                name: 'uom',
                data: 'uom',
            },
            {
                name: 'est_umur',
                data: 'est_umur',
            },
            {
                name: 'unit_price',
                data: 'unit_price',
            },],
        });

        const filterSearch = document.querySelector('[data-kt-data-asset-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            datatableAsset.search(e.target.value).draw();
        });

        initActionAsset();
    }

    var initActionAsset = () => {
        $('.add-item').click(function (e) {
            e.preventDefault();
            $('[data-repeater-create]').trigger('click');
        });
        $('#data-asset_table').on('click', '.select-asset', function (e) {
            e.preventDefault();
            var asset = $(this).data('asset');
            const parent = e.target.closest('tr');
            var arrayTd = parent.querySelectorAll('td');
            populateItem(arrayTd, asset);
            modalAsset.hide();
        });
        $('#data_asset_close').click(function (e) {
            e.preventDefault();
            modalAsset.hide();
        });
    }

    var populateItem = (arrayTd, key) => {
        $($(currentItem).find('.asset')).val(key);
        $($(currentItem).find('.asset-description')).val(arrayTd[2].innerText);
        $($(currentItem).find('.asset-model')).val(arrayTd[3].innerText);
        $($(currentItem).find('select')).val($($(arrayTd[4]).find('span')).data('id'));
        $($(currentItem).find('.umur-asset')).val(arrayTd[5].innerText);
        $($(currentItem).find('.price')).val(arrayTd[6].innerText).trigger('input').trigger('keyup');
        initTotalRepeater();
    }

    var initForm = () => {
        $(`.form-cer`).on('click', `.simpan-form-cer`, function (e) {
            e.preventDefault();
            var postData = new FormData($(`.form-cer`)[0]);
            $(`.simpan-form-cer`).attr("data-kt-indicator", "on");
            $.ajax({
                type: 'POST',
                url: "/asset-requests/store",
                processData: false,
                contentType: false,
                data: postData,
                success: function (response) {
                    $(`.simpan-form-cer`).removeAttr("data-kt-indicator");
                    Swal.fire(
                        'Success!',
                        response.message,
                        'success'
                    ).then(function () {
                        window.location.href = "/asset-requests";
                    });
                },
                error: function (jqXHR, xhr, textStatus, errorThrow, exception) {
                    $(`.simpan-form-cer`).removeAttr("data-kt-indicator");
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
            modalBudget = new bootstrap.Modal(document.querySelector('#data_budget'));

            initPlugins();
            initRepeater();
            initDatatableAsset();
            initDatatableBudget();
            initForm();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTModalCersAdd.init();
});
