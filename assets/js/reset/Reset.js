!function ($) {
    "use strict";
    var $frmReset = $("#frmReset"),
        validate = ($.fn.validate !== undefined);
        var $btn = $("#resetButton");
		if ($frmReset.length > 0 && validate) {
            $frmReset.validate({
                rules:{
                    password: {
                        required: true,
                        alphanumeric: true,
                        nowhitespace: true
                    },
                    confirm: {
                        required: true,
                        alphanumeric: true,
                        nowhitespace: true,
                        equalTo: "#password"
                    },
                },
                submitHandler: function (form) {
					$.ajax({
                        type: "POST",
                        url: $(form).attr('action'),
                        dataType: "json",
                        data: $(form).serialize(),
                        beforeSend: function(){
                            $btn.button('loading');
                        },
                        success: function (json) {
                                $('.alert, .text-danger').remove();
                                if (json['error']) {
                                    if (json['error']['warning']) {
                                        $('#my-container > .reset-form').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '</div>');
                                    }
                    
                                }
                                if (json['success']) {
                                    $('#my-container > .reset-form').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['success'] + '</div>');
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

