!function ($) {
    "use strict";
    var $frmSignUp = $("#frmSignUp"),
        validate = ($.fn.validate !== undefined);
        var $btn = $("#registerButton");
       
		if ($frmSignUp.length > 0 && validate) {
            $frmSignUp.validate({
                rules:{
                        "input-payment-firstname": {
                            required: true,
                            lettersonly: true
                        },
                        "input-payment-lastname": {
                            required: true,
                            lettersonly: true
                        },
                        "input-payment-email": {
                            required: true,
                            email: true
                        },
                        "input-payment-password": {
                            required: true,
                            alphanumeric: true,
                            nowhitespace: true
                        },
                        "input-payment-confirm": {
                            required: true,
                            alphanumeric: true,
                            nowhitespace: true,
                            equalTo: "#input-payment-password"
                        },
                        "input-payment-telephone": {
                            required: true,
                            nowhitespace: true,
                            
                        },
                        "input-payment-agree": {
                            required: true,
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
                                //$('#button-register').button('reset');
                                $.LoadingOverlay("hide");
                                if (json['error']['warning']) {

                                    $('#my-container .signup-form').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                                }
                                //var i;
                                
                                for (var i in json['error']) {
                                    var element = $('#input-payment-' + i.replace('_', '-'));
                                    //console.log(element);
                                    if ($(element).parent().hasClass('input-group')) {
                                        $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                                    } else {
                                        $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                                    }
                                }
                
                                // Highlight any found errors
                                $('.text-danger').parent().addClass('has-error');
                            }
                            if (json['success']) {
                                setTimeout(function() {
                                    $('#my-container > .signup-form').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['success'] + '</div>');
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

