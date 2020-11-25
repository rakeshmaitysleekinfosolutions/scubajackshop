!function ($) {
		"use strict";
    var $frmCreate = $("#frmCreate"),
        $frmUpdate = $("#frmUpdate"),
        dataTable = ($.fn.dataTable !== undefined);

        if ($(".datatable").length > 0 && dataTable) {
            var dataTable = $('.datatable').DataTable( {
                "processing": true,
                "searching" : true,
                "paging": true,
                "order" : [],
                "ajax": {
                    "url": myLabel.category,
                    "type": 'POST',
                    "dataSrc": "data"
                },
                'language': {
                    'loadingRecords': '&nbsp;',
                    'processing': '<div class="spinner"></div>'
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
                window.location.href = myLabel.edit + id;
            }).on('change', '.checkboxStatus', function (e) {
                var id      = $(this).attr('data-id');
                var status  = $(this).val();
                $.ajax({
                    type: "POST",
                    url: myLabel.updateStatus,
                    cache: false,
                    data: {id: id, status: status},
                    success: function (res) {
                        if (res.status) {
                            dataTable.ajax.reload();
                            swal(res.message);
                        }
                    }
                });
            }).on('change', '.setActivityBook', function (e) {
                var id      = $(this).attr('data-id');
                var activity_book  = $(this).val();
                $.ajax({
                    type: "POST",
                    url: myLabel.setToActivityBook,
                    cache: false,
                    data: {id: id, activity_book: activity_book},
                    success: function (res) {
                        if (res.status) {
                            dataTable.ajax.reload();
                            swal(res.message);
                        }
                    }
                });
            }).on('click', '#checkAll', function () {
                $('.datatable input[type=checkbox]').prop('checked', this.checked);
            });
        }
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });
        //Delete
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
        // Summer note
        $(document).ready(function(){
            $('.summernote').summernote({
                height: 200,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false                 // set focus to editable area after initializing summernote
            });
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


}(window.jQuery);

