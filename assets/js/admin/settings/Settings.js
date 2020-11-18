!function ($) {
    "use strict";
    var $frm = $("#frm"),
        validate = ($.fn.validate !== undefined);
        if ($frm.length > 0 && validate) {
            $frm.validate({
                rules:{


                }
            });
        }




    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });

    // Image Manager
    $(document).on('click', 'a[data-toggle=\'image\']', function(e) {
        var $element = $(this);
        var $popover = $element.data('bs.popover'); // element has bs popover?

        e.preventDefault();

        // destroy all image popovers
        $('a[data-toggle="image"]').popover('destroy');

        // remove flickering (do not re-add popover when clicking for removal)
        if ($popover) {
            return;
        }

        $element.popover({
            html: true,
            placement: 'right',
            trigger: 'manual',
            content: function() {
                return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
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

            $element.popover('destroy');
        });

        $('#button-clear').on('click', function() {
            $element.find('img').attr('src', $element.find('img').attr('data-placeholder'));

            $element.parent().find('input').val('');

            $element.popover('destroy');
        });
    });
    $('select[name="country_id"]').on('change', function() {
        var country_id = $('select[name="country_id"]').find(":selected").val();
        $.ajax({
            url: myLabel.states,
            dataType: 'json',
            method: 'POST',
            data: {
                country_id: country_id
            },
            beforeSend: function() {
                $('select[name="country_id"]').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
            },
            complete: function() {
                $('.fa-spin').remove();
            },
            success: function(json) {
               // console.log(json);
                // if (json['postcode_required'] == '1') {
                //     $('input[name=\'postcode\']').parent().parent().addClass('required');
                // } else {
                //     $('input[name=\'postcode\']').parent().parent().removeClass('required');
                // }
                var html = '';
                html = '<option value="">select option</option>';

                if (json['states'] && json['states'] != '') {
                    for (var i = 0; i < json['states'].length; i++) {
                        html += '<option value="' + json['states'][i]['id'] + '"';
                        //console.log(json['states'][i]['id']);
                        if (json['states'][i]['id'] == myLabel.state_id) {

                            html += ' selected="selected"';
                        }

                        html += '>' + json['states'][i]['name'] + '</option>';
                    }
                } else {
                    html += '<option value="0" selected="selected">Empty</option>';
                }

                $('select[name="state_id"]').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('select[name="country_id"]').trigger('change');
    var Youtube = (function () {
        'use strict';
        var video, results;
        var getThumb = function (url, size) {
            if (url === null) {
                return '';
            }
            size    = (size === null) ? 'big' : size;
            results = url.match('[\\?&]v=([^&#]*)');
            video   = (results === null) ? url : results[1];

            if (size === 'small') {
                return 'https://img.youtube.com/vi/' + video + '/3.jpg';
            }
            return 'https://img.youtube.com/vi/' + video + '/0.jpg';
        };

        return {
            thumb: getThumb
        };
    }());
    function ytVidId(url) {
        var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        return (url.match(p)) ? RegExp.$1 : false;
    }
    $('#videoInputBox').bind("paste", function(e){
        // access the clipboard using the api
        var url = e.originalEvent.clipboardData.getData('text');
        if(!ytVidId(url)) {
            swal('Not a valid URL');
        }
        // alert(pastedData);
        var thumb = Youtube.thumb(url);
        //var iframe           = $('iframe:first');
        var youtubeThumb           = $('#youtubeThumb');
        //console.log(youtubeThumb.val());
        youtubeThumb.val(thumb);
        // iframe.attr('src', thumb);
    });

}(window.jQuery);

