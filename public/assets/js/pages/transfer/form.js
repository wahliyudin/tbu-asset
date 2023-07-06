"use strict";

var Form = function () {
    var initAction = () => {
        $('.approv').click(function (e) {
            e.preventDefault();
            var transfer = $(this).data('transfer');
            var target = this;
            $(target).attr("data-kt-indicator", "on");
            Swal.fire({
                title: 'Apa kamu yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin!',
                preConfirm: () => {
                    return new Promise(function (resolve) {
                        $.ajax({
                            type: "POST",
                            url: `/approvals/transfers/${transfer}/approv`,
                            dataType: 'JSON',
                        })
                            .done(function (myAjaxJsonResponse) {
                                $(target).removeAttr("data-kt-indicator");
                                Swal.fire(
                                    'Verified!',
                                    myAjaxJsonResponse.message,
                                    'success'
                                ).then(function () {
                                    location.reload();
                                });
                            })
                            .fail(function (erordata) {
                                $(target).removeAttr("data-kt-indicator");
                                if (erordata.status == 422) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Warning!',
                                        text: erordata.responseJSON
                                            .message,
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: erordata.responseJSON
                                            .message,
                                    })
                                }
                            })
                    })
                },
                willClose: () => {
                    $(target).removeAttr("data-kt-indicator");
                }
            });
        });
        $('.reject').click(function (e) {
            e.preventDefault();
            var transfer = $(this).data('transfer');
            var target = this;
            $(target).attr("data-kt-indicator", "on");
            Swal.fire({
                title: 'Apa kamu yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin!',
                preConfirm: () => {
                    return new Promise(function (resolve) {
                        $.ajax({
                            type: "POST",
                            url: `/approvals/transfers/${transfer}/reject`,
                            dataType: 'JSON',
                        })
                            .done(function (myAjaxJsonResponse) {
                                $(target).removeAttr("data-kt-indicator");
                                Swal.fire(
                                    'Rejected!',
                                    myAjaxJsonResponse.message,
                                    'success'
                                ).then(function () {
                                    location.reload();
                                });
                            })
                            .fail(function (erordata) {
                                $(target).removeAttr("data-kt-indicator");
                                if (erordata.status == 422) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Warning!',
                                        text: erordata.responseJSON
                                            .message,
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: erordata.responseJSON
                                            .message,
                                    })
                                }
                            })
                    })
                },
                willClose: () => {
                    $(target).removeAttr("data-kt-indicator");
                }
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
            initAction();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    Form.init();
});
