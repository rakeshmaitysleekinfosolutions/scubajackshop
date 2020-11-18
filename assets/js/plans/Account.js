!function ($) {
    "use strict";
    var $frm = $("#frm"),
        validate = ($.fn.validate !== undefined);
    var $btn = $("#createAccountBtn");

    if ($frm.length > 0 && validate) {
        $frm.validate({
            rules:{
                firstname: {
                    required: true,
                    lettersonly: true
                },
                lastname: {
                    required: true,
                    lettersonly: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    nowhitespace: true
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    cache: false,
                    data: $(form).serialize(),
                    beforeSend: function(){
                        $.LoadingOverlay("show");
                    },
                    success: function (json) {

                        if (json['error']) {
                            $.LoadingOverlay("hide");
                            if (json['error']['warning']) {
                                $('#my-container .createAccountFrm').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                            }
                            // Highlight any found errors
                            $('.text-danger').parent().addClass('has-error');
                        }
                        if (json['success']) {
                            $('#my-container > .createAccountFrm').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['success'] + '</div>');
                            setTimeout(function() {
                                location.href = json['redirect'];
                            },3000);
                        }
                    }
                });

                return false; // required to block normal submit since you used ajax
            }

        });
    }
}(window.jQuery);

