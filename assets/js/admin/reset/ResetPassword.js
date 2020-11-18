!function ($) {
    "use strict";
    var $frm = $("#frm"),
        $frmUpdate = $("#frmUpdate"),
        validate = ($.fn.validate !== undefined);
    if ($frm.length > 0 && validate) {
        $frm.validate({
            rules:{
                "old": {
                    required: true,
                },
                "password": {
                    required: true,
                },
                "confirm": {
                    required: true,
                    equalTo: "#input-password"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    dataType: "json",
                    data: $(form).serialize(),
                    success: function (json) {
                        if (json['warning']) {
                            swal({
                                title: "Warning",
                                text: json['warning'],
                                type: "warning",
                            });
                            //$('#my-container #frm').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        }

                        if (json['success']) {
                            swal({
                                title: "Success",
                                text: json['success'],
                                type: "success",
                            });
                            $('#frm')[0].reset();
                            //$('#my-container > #frm').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['success'] + '</div>');
                        }
                    }
                });

                return false; // required to block normal submit since you used ajax
            }


        });
    }
}(window.jQuery);

