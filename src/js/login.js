$("#myModal").modal('show');
var $logInModalForm = $("#logInModalForm"),validate = ($.fn.validate !== undefined);
if ($logInModalForm.length > 0 && validate) {
    $logInModalForm.validate({
        rules:{
            email: {
                required: true,
                email: true
            },
            password: {
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
                    $('#logInModalButton').LoadingOverlay("show");
                },
                success: function (json) {
                    console.log(json);
                    $('#logInModalButton').LoadingOverlay("hide");
                    if (json['error']) {
                        if (json['error']['warning']) {
                            $.LoadingOverlay("hide");
                            $('#my-container > .signin-form').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '</div>');
                        }
                    }
                    if (json['success']) {
                        $('#my-container > .signin-form').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['success'] + '</div>');
                        setTimeout(function() {
                            //$("[data-pd-popup-close]").trigger('click');
                            //location.href = myLabel.baseUrl;
                            $("#myModal").modal('hide');
                            window.reload();
                        },800);

                    }

                }
            });

            return false; // required to block normal submit since you used ajax
        }

    });
}
