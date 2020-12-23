!function ($) {
    "use strict";
    var $frmSignIn = $("#frmSignIn"),validate = ($.fn.validate !== undefined);
    var $btn = $("#logInButton");
		if ($frmSignIn.length > 0 && validate) {
            $frmSignIn.validate({
                rules:{
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
                        dataType: "json",
                        data: $(form).serialize(),
                        beforeSend: function() {
                            $.LoadingOverlay("show");
                        },
                        success: function (json) {
                                
                                if (json['error']) {
                                    if (json['error']['warning']) {
                                        $.LoadingOverlay("hide");
                                        $('#my-container > .signin-form').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '</div>');
                                    }
                                }
                                if (json['success']) {
                                    setTimeout(function() {
                                        $('#my-container > .signin-form').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['success'] + '</div>');
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

