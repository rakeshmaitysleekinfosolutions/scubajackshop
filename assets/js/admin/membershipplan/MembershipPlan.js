!function ($) {
    "use strict";
    var $frm = $("#frm"),
        $frmUpdate = $("#frmUpdate"),
        validate = ($.fn.validate !== undefined);
    dataTable = ($.fn.dataTable !== undefined);

    if ($frm.length > 0 && validate) {
        $frm.validate({
            rules:{
                name: {
                    required: true,
                    maxWords: 128
                },
                description: {
                    required: true,
                    maxWords: 127
                },
                price: {
                    required: true,
                    decimal: true
                }
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
            window.location.href = myLabel.edit + id;
        }).on('change', '.onChangeStatus', function (e) {
            var id      = $(this).attr('data-id');
            var status  = $(this).val();
            $.ajax({
                type: "POST",
                url: myLabel.status,
                cache: false,
                data: {id: id, status: status},
                success: function (res) {
                    if (res.status) {
                        dataTable.ajax.reload();
                    }
                }
            });
        }).on('click', '#checkAll', function () {
            $('.datatable input[type=checkbox]').prop('checked', this.checked);
        });
    }
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

    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });
    $(document).on('click', '#addAnswerButton', function (e) {
        console.log(myLabel.increment);
        var html = '';
        html = '<tr id="answers-row' + myLabel.increment + '">';
        html += '  <td class="text-left"><textarea class="form-control" type="text" name="answers[' + myLabel.increment + '][answer]" id="input-answer[' + myLabel.increment + '][answer]" autocomplete="off" ></textarea></td>';
        // html += '  <td class="text-left">\
        //                 <select name="answers[' + myLabel.increment + '][isCorrect]" class="select floating" id="input-is_correct" >\
        //                     <option value="0" >NO</option>\
        //                     <option value="1" >YES</option>\
        //             </select>\
        //     </td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#answers-row' + myLabel.increment + '\').remove();" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#answers tbody').append(html);
        myLabel.increment++;
    });
    $(document).ready(function(){
        $('#input-frequency_interval').trigger('change');
    });

    $(document).on('change', '#input-frequency_interval', function (e) {
        var frequency_interval = $(this).val();
        var days = frequency_interval * 30;
        console.log(days);
        $('#input-duration').val(days);
    });
}(window.jQuery);

