var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
        var $frmCreate = $("#frmCreate"),
            $frmUpdate = $("#frmUpdate"),
            validate = ($.fn.validate !== undefined),
        dataTable = ($.fn.dataTable !== undefined),
        treeNodes = ($.fn.treeNodes !== undefined),treeNodeUrl = '';
        /** Create Form Validation */

		if ($frmCreate.length > 0 && validate) {
            $frmCreate.validate({
                rules:{
                    show_from: {
                        required: true,
                    },
                    show_until: {
                        required: true,
                        greaterThan: "#show_from"
                    },
                    sell_from: {
                        required: true,
                    },
                    sell_until: {
                        required: true,
                        greaterThan: "#sell_from"
                    }
                },
                // messages: {
                //     identity: {
                //         required: "Please enter your registered email address",
                //         email: "Your email address must be in the format of name@domain.com"
                //     }
                // },
                onkeyup: false,
                wrapper: "em",
                ignore: "",
            });
            tinymce.init({
				document_base_url : myLabel.baseUrl,
				relative_urls : false,
				remove_script_host : false,
                selector: "textarea.mceEditor",
                height: 300,
                resize: false,  
		    	theme: "modern",
		    	plugins: [
			         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
			         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
			         "save table contextmenu directionality emoticons paste textcolor"
			         ],
		        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons"
            });
            
			
            
        }
        if ($frmUpdate.length > 0) {
            
            tinymce.init({
				document_base_url : myLabel.baseUrl,
				relative_urls : false,
				remove_script_host : false,
                selector: "textarea.mceEditor",
                height: 300,
                resize: false,  
		    	theme: "modern",
		    	plugins: [
			         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
			         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
			         "save table contextmenu directionality emoticons paste textcolor"
			         ],
		        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons"
            });
            
			
            
        }
        if ($(".js-dataTable-full-pagination").length > 0 && dataTable) {
            var dataTable = $('.js-dataTable-full-pagination').DataTable( {
                "processing": true,
                "ajax": {
                    "url": myLabel.baseUrl + "/events/data",
                    "method" : 'POST',
                    "dataSrc": "data"
                },
                "oLanguage": {
                    "sEmptyTable": "Empty Table"
                },
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Export',
                        buttons: [
                            'copy',
                            'excel',
                            'csv',
                            'pdf',
                            'print'
                        ]
                    }
                ],
                "columnDefs": [ {
                    "targets": 0,
                    "orderable": false
                },{
                    visible: false
                } ],
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            }).on('click', '._edit', function(e) {
                var id = $(this).data('id');
                window.location.href = myLabel.baseUrl + '/events/edit/' + id;
            }).on('click', '._delete', function(e) {
                var id = $(this).data('id');
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
                            type: "GET",
                            url: myLabel.baseUrl + '/events/delete/' + id,
                            cache: false,
                            success: function(res) { 
                                if(res.status === true) {
                                    swal(res.message);
                                } else {
                                    swal(res.message);
                                }
                                
                                dataTable.ajax.reload();
                            }
                        });
                    }, 2000);
                  });
                
            }).on('click', '#checkAll', function() {
                $('.js-dataTable-full-pagination input[type=checkbox]').prop('checked', this.checked);    
            }).on('click', '#addNewSeatMap', function(e) {
                var id = $(this).data('id');
                window.location.href = myLabel.baseUrl + '/event/' + id + '/seatmaps/create';
            });
            
        }
        /** List of Records */
      
        
       
        
        $(document).on("click", "#deleteAllSelected", function (e) {
            e.preventDefault();
            console.log(1);
            var arrayId = [];
            $('.js-dataTable-full-pagination input[type=checkbox]').each(function() {
              if($(this).is(":checked")) {
                var id = $(this).data('id');
                if(id == undefined || id == 0 || id == '' || id == null) {

                } else {
                    arrayId.push(id);
                }
              }
            });
           
            if(arrayId.length > 0) {
                
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
                            url: myLabel.baseUrl + '/events/bulk/delete/',
                            data: { arrayId: arrayId},
                            cache: false,
                            success: function(res) { 
                                if(res.status === true) {
                                    swal(res.message);
                                } else {
                                    swal(res.message);
                                }
                                
                                dataTable.ajax.reload();
                            }
                        });
                    }, 2000);
                  });
                /*
                var isDelete = confirm("Do you really want to delete records?");
                if (isDelete == true) {
                   // AJAX Request
                   $.ajax({
                      url: 'ajaxfile.php',
                      type: 'POST',
                      data: { records: arrayId},
                      success: function(response){
                         $.each(post_arr, function( i,l ){
                             $("#tr_"+l).remove();
                         });
                      }
                   });
                } 
                */
            } else {
                swal("You must select one record");
            }
        });
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });
        $('input[name="template_type"]:radio').change(function () {
            var template_type = parseInt($("input[name='template_type']:checked").val());
            console.log(template_type);
            if(template_type === 0) {
                document.getElementById('ticket_template').style.display = 'block';
                document.getElementById('bracelet_template').style.display = 'none';
            } else {
                document.getElementById('bracelet_template').style.display = 'block';
                document.getElementById('ticket_template').style.display = 'none';
            }
        });
        $('input[name="is_vat"]:radio').change(function () {
            var is_vat = parseInt($("input[name='is_vat']:checked").val());
            console.log(is_vat);
            $('#is_vat').val(is_vat);
        });
        $('input[name="is_additional_cost"]:radio').change(function () {
            var is_additional_cost = parseInt($("input[name='is_additional_cost']:checked").val());
            $('#is_additional_cost').val(is_additional_cost);
        });
        $('input[name="additional_cost_type"]:radio').change(function () {
            var additional_cost_type = parseInt($("input[name='additional_cost_type']:checked").val());
            $('#additional_cost_type').val(additional_cost_type);
        });
        $('input[name="vat_type"]:radio').change(function () {
            var vat_type = parseInt($("input[name='vat_type']:checked").val());
            $('#vat_type').val(vat_type);
        });
        //$('#publishing_type_automatic').trigger('change');
        // $("#publishing_type_automatic input:radio").click(function() {

        //     alert("clicked");

        // });
        //$("#publishing_type_automatic").attr('checked', true).trigger('change');
        //$('input[name="publishing_type"]:radio').click();

        $('input[name="publishing_type"]:radio').change(function () {
            var publishing_type = parseInt($("input[name='publishing_type']:checked").val());
            $('#publishing_type').val(publishing_type);
            if(publishing_type === 0) {
                document.getElementById('manual').style.display = 'flex';
                document.getElementById('automatic').style.display = 'none';
            } else {
                document.getElementById('automatic').style.display = 'flex';
                document.getElementById('manual').style.display = 'none';
            }
        });
        $("#EventDateTime").datetimepicker({
            minDate: '',
            onChangeDateTime: function() {
                console.log(1);
                var EventDateTime = document.getElementById('EventDateTime').value;
                var eDate = new Date();
                var sDate = new Date(EventDateTime);
                console.log('eDate:' + eDate, 'sDate:' + sDate);
                if(EventDateTime != '' && sDate < eDate)
                {
                    swal("Please ensure that the Event Date is greater than or equal to the ToDay.");
                    return false;
                } 
            }
        });
        $("#ShowFrom").datetimepicker({
            minDate: '',
            onChangeDateTime: function() {
               
                var ShowFrom= document.getElementById('ShowFrom').value;
                var eDate = new Date();
                var sDate = new Date(ShowFrom);
                console.log('eDate:' + eDate, 'sDate:' + sDate);
                if(ShowFrom!= '' && sDate < eDate)
                {
                    swal("Please ensure that the ShowFrm Date is greater than or equal to the ToDay.");
                    return false;
                } 
                
            }
        });
        $("#ShowUntil").datetimepicker({ 
            minDate: '',
            onChangeDateTime: function(selected) {
               //$("#ShowFrom").datetimepicker("option","maxDateTime", selected)
                var ShowFrom= document.getElementById('ShowFrom').value;
                var ShowUntil= document.getElementById('ShowUntil').value;
                var eDate = new Date(ShowUntil);
                var sDate = new Date(ShowFrom);
                if(ShowFrom!= '' && ShowFrom!= '' && sDate> eDate)
                {
                    swal("Please ensure that the ShowUntil Date is greater than or equal to the ShowFrom Date.")
                   // alert();
                    return false;
                }
            }
        });  
        $("#SellFrom").datetimepicker({
            minDate: '',
            onChangeDateTime: function(selected) {
              //$("#SellUntil").datetimepicker("option","minDateTime", selected)
              var SellFrom= document.getElementById('SellFrom').value;
                var eDate = new Date();
                var sDate = new Date(SellFrom);
                console.log('eDate:' + eDate, 'sDate:' + sDate);
                if(SellFrom!= '' && sDate < eDate)
                {
                    swal("Please ensure that the SellFrom Date is greater than or equal to the ToDay.");
                    return false;
                } 
            }
        });
        $("#SellUntil").datetimepicker({ 
            minDate: '',
            onChangeDateTime: function(selected) {
               //$("#SellFrom").datetimepicker("option","maxDateTime", selected)
                var SellFrom= document.getElementById('SellFrom').value;
                var SellUntil= document.getElementById('SellUntil').value;
                var eDate = new Date(SellUntil);
                var sDate = new Date(SellFrom);
                if(SellFrom!= '' && SellFrom!= '' && sDate> eDate)
                {
                    swal("Please ensure that the SellFrm Date is greater than or equal to the ShowUntil Date.")
                    return false;
                }
            }
        }); 
        $('.datetimepicker').datetimepicker({
            minDate: '',
            // mask:'9999/19/39 29:59',
             format:'Y:m:d H:i',
             showApplyButton: true
             /*
             ownerDocument: document,
             contentWindow: window,
             value: '',
             rtl: false,
             format: 'Y/m/d H:i',
             formatTime: 'H:i',
             formatDate: 'Y/m/d',
             startDate:  false, // new Date(), '1986/12/08', '-1970/01/05','-1970/01/05',
             step: 60,
             monthChangeSpinner: true,
             closeOnDateSelect: false,
             closeOnTimeSelect: true,
             closeOnWithoutClick: true,
             closeOnInputClick: true,
             openOnFocus: true,
             timepicker: true,
             datepicker: true,
             weeks: false,
             defaultTime: false, // use formatTime format (ex. '10:00' for formatTime: 'H:i')
             defaultDate: false, // use formatDate format (ex new Date() or '1986/12/08' or '-1970/01/05' or '-1970/01/05')
             minDate: false,
             maxDate: false,
             minTime: false,
             maxTime: false,
             minDateTime: false,
             maxDateTime: false,
             allowTimes: [],
             opened: false,
             initTime: true,
             inline: false,
             theme: '',
             touchMovedThreshold: 5,
             onSelectDate: function () {},
             onSelectTime: function () {},
             onChangeMonth: function () {},
             onGetWeekOfYear: function () {},
             onChangeYear: function () {},
             onChangeDateTime: function () {},
             onShow: function () {},
             onClose: function () {},
             onGenerate: function () {},
             withoutCopyright: true,
             inverseButton: false,
             hours12: false,
             next: 'xdsoft_next',
             prev : 'xdsoft_prev',
             dayOfWeekStart: 0,
             parentID: 'body',
             timeHeightInTimePicker: 25,
             timepicker: true,
             todayButton: true,
             prevButton: true,
             nextButton: true,
             defaultSelect: true,
             scrollMonth: true,
             scrollTime: true,
             scrollInput: true,
             lazyInit: false,
             mask: false,
             validateOnBlur: true,
             allowBlank: true,
             yearStart: 1950,
             yearEnd: 2050,
             monthStart: 0,
             monthEnd: 11,
             style: '',
             id: '',
             fixed: false,
             roundTime: 'round', // ceil, floor
             className: '',
             weekends: [],
             highlightedDates: [],
             highlightedPeriods: [],
             allowDates : [],
             allowDateRe : null,
             disabledDates : [],
             disabledWeekDays: [],
             yearOffset: 0,
             beforeShowDay: null,
             enterLikeTab: true,
             showApplyButton: false
             */
         });
       
	});
})(jQuery_1_8_2);

