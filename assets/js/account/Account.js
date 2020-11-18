!function ($) {
    "use strict";
    var $frm = $("#frm"),
        validate = ($.fn.validate !== undefined);
    var $btn = $("#btn");

    if ($frm.length > 0 && validate) {
        $frm.validate({
            rules:{
                firstname: {
                    required: true,
                },
                lastname: {
                    required: true,
                },
                gender: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    alphanumeric: true,
                    nowhitespace: true
                },
                confirm: {
                    alphanumeric: true,
                    nowhitespace: true,
                    equalTo: password
                }
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

                        if (json['error']) {
                            //$('#button-register').button('reset');

                            if (json['error']['warning']) {
                                $('#my-container .frm').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                            }
                            //var i;

                            for (var i in json['error']) {
                                var element = $('#input-' + i.replace('_', '-'));
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
                            $('#my-container > .frm').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['success'] + '</div>');
                            $btn.button('reset');
                        }
                    }
                });

                return false; // required to block normal submit since you used ajax
            }

        });

    }
    // Image Manager
    $(document).on('click', 'a[data-toggle=\'image\']', function(e) {
        var $element = $(this);
        var $popover = $element.data('bs.popover'); // element has bs popover?

        e.preventDefault();

        // destroy all image popovers
        $('a[data-toggle="image"]').popover('dispose');

        // remove flickering (do not re-add popover when clicking for removal)
        if ($popover) {
            return;
        }

        $element.popover({
            html: true,
            placement: 'right',
            trigger: 'manual',
            content: function() {
                return '<button type="button" id="button-image" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>';
            }
        });

        $element.popover('show');

        $('#button-image').on('click', function() {
            var $button = $(this);
            var $icon   = $button.find('> i');

            $('#modal-image').remove();

            $.ajax({
                url: myLabel.filemanager + '?target=' + $element.parent().find('input').attr('id') + '&thumb=' + $element.attr('id') + '&type=' + $element.attr('type'),
                dataType: 'html',
                beforeSend: function() {
                    $button.prop('disabled', true);
                    if ($icon.length) {
                        $icon.attr('class', 'fa fa-circle-o-notch fa-spin');
                    }
                },
                complete: function() {
                    $button.prop('disabled', false);

                    if ($icon.length) {
                        $icon.attr('class', 'fa fa-pencil');
                    }
                },
                success: function(html) {
                    $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                    $('#modal-image').modal('show');
                }
            });

            $element.popover('dispose');
        });

        $('#button-clear').on('click', function() {
            $element.find('img').attr('src', $element.find('img').attr('data-placeholder'));

            $element.parent().find('input').val('');

            $element.popover('dispose');
        });
    });
}(window.jQuery);

