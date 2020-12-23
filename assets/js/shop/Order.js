!function ($) {
    "use strict";
    dataTable = ($.fn.dataTable !== undefined);
    if ($(".datatable").length > 0 && dataTable) {
        var dataTable = $('.datatable').DataTable( {
            "processing": true,
            "searching" : true,
            "paging": true,
            "order" : [],
            "ajax": {
                "url": myLabel.fetch,
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
        }).on('change', '.updateStatus', function (e) {
            var id      = $(this).attr('data-id');
            var status  = $(this).val();
            $.ajax({
                type: "POST",
                url: myLabel.status,
                cache: false,
                data: {order_id: id, order_status_id: status},
                success: function (json) {
                    if (json['status']) {
                        dataTable.ajax.reload();
                        $('#message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['message'] + '</div>');
                    }

                }
            });
        }).on('click', '#checkAll', function () {
            $('.datatable input[type=checkbox]').prop('checked', this.checked);
        });
    }

    //Delete
    $(document).on('click', '#delete', function (e) {
        var selected = [];
        $('#datatable .selectCheckbox').each(function () {
            if ($(this).is(":checked")) {
                var id = $(this).val();
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
    $(document).on('change', '#status', function (e) {
        var id      = $(this).attr('data-order_id');
        var status  = $(this).val();
        $.ajax({
            type: "POST",
            url: myLabel.status,
            cache: false,
            data: {order_id: id, order_status_id: status},
            success: function (json) {
                if (json['status']) {
                    $('#message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i>  ' + json['message'] + '</div>');
                    //dataTable.ajax.reload();

                }
            }
        });
    });
}(window.jQuery);

