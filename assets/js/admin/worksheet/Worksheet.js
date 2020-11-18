!function ($) {
    "use strict";
    var $frm = $("#frm"),
        validate = ($.fn.validate !== undefined);
    dataTable = ($.fn.dataTable !== undefined);

    if ($frm.length > 0 && validate) {
        $frm.validate({
            rules:{
            }
        });
    }

    if ($(".datatable").length > 0 && dataTable) {
        var dataTable = $('.datatable').DataTable( {
            "processing": true,
            'language': {
                'loadingRecords': '&nbsp;',
                'processing': '<div class="spinner"></div>'
            },
            "searching" : true,
            "paging": true,
            "order" : [],
            "ajax": {
                "url": myLabel.index,
                "type": 'POST',
                "dataSrc": "data"
            },
            "oLanguage": {
                "sEmptyTable": "Empty Table"
            },
            dom: 'lBfrtip',
            buttons: [
                'excel', 'csv', 'pdf'
            ],
            "columnDefs": [ {
                "targets": 0,
                "orderable": false
            },{
                visible: false
            } ],
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
        }).on('click', '.edit', function (e) {
            var id = $(this).data('id');
            window.location.href = myLabel.edit + id ;
        }).on('click', '#checkAll', function () {
            $('.datatable input[type=checkbox]').prop('checked', this.checked);
        });
    }
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
    //Delete Records
    $(document).on('click', '#delete', function (e) {
        var selected = [];
        $('.datatable .selectCheckbox').each(function () {
            if ($(this).is(":checked")) {
                var id = $(this).data('id');

                if (id != undefined || id != 0 || id != '' || id != null) {
                    selected.push(id);
                }
            }
        });

        if (selected.length > 0) {
            swal({
                title: "Confirm Delete",
                text: "Are you want to delete this record?(Yes/No)",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {

                setTimeout(function () {
                    $.ajax({
                        type: "POST",
                        url: myLabel.delete,
                        data: {selected: selected},
                        cache: false,
                        success: function (res) {
                            if (res.status === true) {
                                swal(res.message);
                            } else {
                                swal(res.message);
                            }

                            dataTable.ajax.reload();
                        }
                    });
                }, 2000);

            });
        } else {
            swal("You must select one record");
        }
    });
    $(document).on('click', '.addData', function (e) {
        var html = '';
        html = '<tr id="data-row' + myLabel.counter + '">';
        html += '  <td class="text-left"><a href="javascript:void(0);" type="craft" id="thumb-craft' + myLabel.counter + '"data-toggle="image" class="img-thumbnail"><img src="'+myLabel.placeholder+'" alt="" title="" data-placeholder="'+myLabel.placeholder+'" /></a><input type="hidden" name="worksheets[' + myLabel.counter + '][data]" value="" id="input-data' + myLabel.counter + '" /></td>';
        html += '  <td class="text-left"><input type="text" name="worksheets[' + myLabel.counter + '][title]" value="" class="form-control" id="input-title' + myLabel.counter + '" data-placeholder="Video Url" required></td>';
        html += '  <td class="text-left"><input type="text" name="worksheets[' + myLabel.counter + '][sort_order]" value="" class="form-control" id="input-sort_order' + myLabel.counter + '" data-placeholder="Sort Order" required></td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#data-row' + myLabel.counter + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#worksheets tbody').append(html);
        myLabel.counter++;
    });
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });
}(window.jQuery);

