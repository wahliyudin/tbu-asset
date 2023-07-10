"use strict";

var Form = function () {

    var initForm = () => {
        $(`.form-asset`).on('click', `.simpan`, function (e) {
            e.preventDefault();
            var postData = new FormData($(`.form-asset`)[0]);
            var cer = $(this).data('cer');
            $(`.simpan`).attr("data-kt-indicator", "on");
            $.ajax({
                type: 'POST',
                url: `/asset-requests/${cer}/register`,
                processData: false,
                contentType: false,
                data: postData,
                success: function (response) {
                    $(`.simpan`).removeAttr("data-kt-indicator");
                    Swal.fire(
                        'Success!',
                        response.message,
                        'success'
                    ).then(function () {
                        window.location.href = "/asset-requests";
                    });
                },
                error: function (jqXHR, xhr, textStatus, errorThrow, exception) {
                    $(`.simpan`).removeAttr("data-kt-indicator");
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

    var initPlugins = () => {
        $("#tgl_bast").flatpickr();
        $('.uang').mask('0.000.000.000', {
            reverse: true
        });
    }

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            initForm();
            initPlugins();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    Form.init();
});
