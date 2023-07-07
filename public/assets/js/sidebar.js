"use strict";

var List = function () {

    var fatchTotals = () => {
        $.ajax({
            type: "GET",
            url: "/global/total-approvals",
            dataType: "JSON",
            success: function (response) {
                fill(response);
            }
        });
    }

    var fill = (data) => {
        $('#grand-total').text(data?.grand_total);
        $('#asset-request').text(data?.request);
        $('#asset-transfer').text(data?.transfer);
        $('#asset-dispose').text(data?.dispose);
    }

    return {
        init: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fatchTotals();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    List.init();
});
