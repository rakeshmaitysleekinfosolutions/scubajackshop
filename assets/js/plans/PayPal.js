!function ($) {
    "use strict";
    $(document).on('click', '#processToPayPal', function (e) {
        var planId = $('#planId').val();
        $.ajax({
            type: "POST",
            url: myLabel.paypal,
            data: {
                planId: planId
            },
            beforeSend: function() {
                $.LoadingOverlay("show");
            },
            cache: false,
            success: function (json) {
                if (json['success']) {
                    setTimeout(function() {
                        location.href = json['redirect'];
                    },3000);
                }
            }
        });
    });
}(window.jQuery);

