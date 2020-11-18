!function ($) {
    "use strict";
    var $frmForgotten = $("#frmForgotten"),
        validate = ($.fn.validate !== undefined);
        var $btn = $("#forgottenButton");
		if ($frmForgotten.length > 0 && validate) {
            $frmForgotten.validate({
                rules:{
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email address",
                        email: "Your email address must be in the format of name@domain.com"
                    }
                },
                onkeyup: false,
                wrapper: "em",
                ignore: "",
                submitHandler: function (form) {
					$.ajax({
                        type: "POST",
                        url: myLabel.forgotten,
                        dataType: "json",
                        data: $(form).serialize(),
                        beforeSend: function(){
                            $btn.button('loading');
                        },
                        success: function (json) {
                               
                                if (json['error']) {
                                    if (json['error']['warning']) {
                                        $('#my-container > .fogotten-form').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '</div>');
                                    }
                    
                                }
                                if (json['success']) {
                                    $('#my-container > .fogotten-form').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['success'] + '</div>');
                                    $btn.button('reset');
                                    setTimeout(function() {
                                        location.href = json['redirect'];
                                    },1000);
                                }
                            
                        }
                    });
					
					return false; // required to block normal submit since you used ajax
				}
                
            });
        }
}(window.jQuery);

