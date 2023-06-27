"use strict";

var list = function () {

    var initAction = () => {
        $(".checkall_modul").click(function () {
            var menu = this.value;
            $("." + menu).prop('checked', this.checked);
            $(".sub_" + menu).prop('checked', this.checked);
        });

        $(".checkall_fitur").click(function () {
            var modulid = this.value;
            $(this).closest('tr').find('.fitur').prop('checked', this.checked);
        });

        $(".fitur").click(function () {
            var countActivefitur = $(this).closest('tr').find('.fitur:checked').length;
            if (countActivefitur > 0) {
                $(this).closest('tr').find('.checkall_fitur').prop('checked', true);
            } else {
                $(this).closest('tr').find('.checkall_fitur').prop('checked', false);
            }
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
    }
}();

KTUtil.onDOMContentLoaded(function () {
    list.init();
});
