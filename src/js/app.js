require('./bootstrap');
require('./additional-methods');
require('./jquery.validate');
require('./loadingoverlay.min');
require ('./jquery.slimscroll');

import 'datatables.net-bs4'
import 'jquery-ui/ui/widgets/datepicker.js';
import 'select2/dist/js/select2';
import 'summernote';
import 'jquery-ui/ui/widgets/datepicker.js';
import 'bootstrap-datepicker';
import 'timepicker';

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(function () {
    if($('.datetimepicker').length > 0 ){
        $('.datetimepicker').datepicker({
            format: 'mm/dd/yyyy'
        });
    }
    if($('.timepicker').length > 0 ){
        $('.timepicker').timepicker({});
    }
});
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
var $sidebarOverlay = $(".task-overlay");
$(".task-chat, #mobile_btn").on("click", function(e) {
    var $target = $($(this).attr("href"));
    if ($target.length) {
        $target.toggleClass("opened");
        $sidebarOverlay.toggleClass("opened");
        $("html").toggleClass("menu-opened");
        $sidebarOverlay.attr("data-reff", $(this).attr("href"))
    }
    e.preventDefault()
});

$sidebarOverlay.on("click", function(e) {
    var $target = $($(this).attr("data-reff"));
    if ($target.length) {
        $target.removeClass("opened");
        $("html").removeClass("menu-opened");
        $(this).removeClass("opened")
        $(".main-wrapper").removeClass("slide-nav-toggle");
    }
    e.preventDefault()
});

$(document).ready(function() {
    if($('.themes-icon').length > 0 ){
        $(".themes-icon").click(function () {
            $('.themes').toggleClass("active");
            $('.main-wrapper').removeClass('open-msg-box');
        });
    }
});

!function($) {
    "use strict";
    var Sidemenu = function() {
        this.$menuItem = $("#sidebar-menu a")
    };

    Sidemenu.prototype.menuItemClick = function(e) {
        if($(this).parent().hasClass("submenu")) {
            e.preventDefault();
        }
        if(!$(this).hasClass("subdrop")) {
            $("ul",$(this).parents("ul:first")).slideUp(350);
            $("a",$(this).parents("ul:first")).removeClass("subdrop");
            $(this).next("ul").slideDown(350);
            $(this).addClass("subdrop");
        }else if($(this).hasClass("subdrop")) {
            $(this).removeClass("subdrop");
            $(this).next("ul").slideUp(350);
        }
    },

        Sidemenu.prototype.init = function() {
            var $this  = this;
            $this.$menuItem.on('click', $this.menuItemClick);
            $("#sidebar-menu ul li.submenu a.active").parents("li:last").children("a:first").addClass("active").trigger("click");
        },
        $.Sidemenu = new Sidemenu, $.Sidemenu.Constructor = Sidemenu
}(window.jQuery),

    function($) {
        "use strict";
        var App = function() {
            this.$body = $("body")
        };
        App.prototype.init = function() {
            var $this = this;
            $(document).ready($this.onDocReady);
            $.Sidemenu.init();
        },
            $.App = new App, $.App.Constructor = App
    }(window.jQuery),

    function($) {
        "use strict";
        $.App.init();
    }(window.jQuery);

$(document).ready(function() {
    if($('.select').length > 0 ){
        $('.select').select2({
            minimumResultsForSearch: -1,
            width: '100%'
        });
    }
});

$(document).ready(function() {
    if($('.modal').length > 0 ){
        var modalUniqueClass = ".modal";
        $('.modal').on('show.bs.modal', function(e) {
            var $element = $(this);
            var $uniques = $(modalUniqueClass + ':visible').not($(this));
            if ($uniques.length) {
                $uniques.modal('hide');
                $uniques.one('hidden.bs.modal', function(e) {
                    $element.modal('show');
                });
                return false;
            }
        });
    }
});

$(document).ready(function() {
    if($('.floating').length > 0 ){
        $('.floating').on('focus blur', function (e) {
            $(this).parents('.form-focus').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
    }
});

$(document).ready(function() {
    if($('.msg-list-scroll').length > 0 ){
        $('.msg-list-scroll').slimscroll({
            height:'100%',
            color: '#878787',
            disableFadeOut : true,
            borderRadius:0,
            size:'4px',
            alwaysVisible:false,
            touchScrollStep : 100
        });
        var h=$(window).height()-124;
        $('.msg-list-scroll').height(h);
        $('.msg-sidebar .slimScrollDiv').height(h);

        $(window).resize(function(){
            var h=$(window).height()-124;
            $('.msg-list-scroll').height(h);
            $('.msg-sidebar .slimScrollDiv').height(h);
        });
    }
});

$(document).ready(function(){
    if($('.slimscroll').length > 0 ){
        $('.slimscroll').slimScroll({
            height: 'auto',
            width: '100%',
            position: 'right',
            size: "7px",
            color: '#ccc',
            wheelStep: 10,
            touchScrollStep : 100
        });
        var h=$(window).height()-60;
        $('.slimscroll').height(h);
        $('.sidebar .slimScrollDiv').height(h);

        $(window).resize(function(){
            var h=$(window).height()-60;
            $('.slimscroll').height(h);
            $('.sidebar .slimScrollDiv').height(h);
        });
    }
});

$(document).ready(function(){
    if($('.page-wrapper').length > 0 ){
        var height = $(window).height();
        $(".page-wrapper").css("min-height", height);
    }
});

$(window).resize(function(){
    if($('.page-wrapper').length > 0 ){
        var height = $(window).height();
        $(".page-wrapper").css("min-height", height);
    }
});





$(document).ready(function() {
    if($('[data-toggle="tooltip"]').length > 0 ){
        $('[data-toggle="tooltip"]').tooltip();
    }
});

$(document).ready(function(){
    if($('.btn-toggle').length > 0 ){
        $('.btn-toggle').click(function() {
            $(this).find('.btn').toggleClass('active');
            if ($(this).find('.btn-success').size()>0) {
                $(this).find('.btn').toggleClass('btn-success');
            }
        });
    }
});

$(document).ready(function() {
    if($('.main-wrapper').length > 0 ){
        var $wrapper = $(".main-wrapper");
        $(document).on('click', '#mobile_btn', function (e) {
            $(".dropdown.open > .dropdown-toggle").dropdown("toggle");
            return false;
        });
        $(document).on('click', '#mobile_btn', function (e) {
            $wrapper.toggleClass('slide-nav-toggle');
            $('#chat_sidebar').removeClass('opened');
            return false;
        });
        $(document).on('click', '#open_msg_box', function (e) {
            $wrapper.toggleClass('open-msg-box').removeClass('');
            $('.themes').removeClass('active');
            $('.dropdown').removeClass('open');
            return false;
        });
    }
});

$(document).ready(function(){
    if($('.dropdown-toggle').length > 0 ){
        $('.dropdown-toggle').click(function() {
            if ($('.main-wrapper').hasClass('open-msg-box')){
                $('.main-wrapper').removeClass('open-msg-box');
            }
        });
    }
});

$( document ).ready(function() {
    $('.table-responsive').on('shown.bs.dropdown', function (e) {
        var $table = $(this),
            $dropmenu = $(e.target).find('.dropdown-menu'),
            tableOffsetHeight = $table.offset().top + $table.height(),
            menuOffsetHeight = $dropmenu.offset().top + $dropmenu.outerHeight(true);

        if (menuOffsetHeight > tableOffsetHeight)
            $table.css("padding-bottom", menuOffsetHeight - tableOffsetHeight);
    });
    $('.table-responsive').on('hide.bs.dropdown', function () {
        $(this).css("padding-bottom", 0);
    });

    $('a[data-toggle="modal"]').on('click',function(){
        setTimeout(function(){ if($(".modal.custom-modal").hasClass('in')){
            $(".modal-backdrop").addClass('custom-backdrop');

        } },500);
    });
});

$(document).ready(function() {
    if($('.clickable-row').length > 0 ){
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    }
});
$( document ).ready(function() {
    if($('.checkbox-all').length > 0 ){
        $('.checkbox-all').click(function () {
            $('.checkmail').click();
        });
    }
    if($('.checkmail').length > 0 ){
        $('.checkmail').each(function() {
            $(this).click(function() {
                if($(this).closest('tr').hasClass("checked")){
                    $(this).closest('tr').removeClass('checked');
                } else {
                    $(this).closest('tr').addClass('checked');
                }
            });
        });
    }
    if($('.mail-important').length > 0 ){
        $(".mail-important").click(function(){
            $(this).find('i.fa').toggleClass("fa-star");
            $(this).find('i.fa').toggleClass("fa-star-o");
        });
    }
});
$(document).ready(function() {
    if($('select').length > 0 ){
        $('select').select2({
            width: '100%'
        });
    }
});
$('.summernote').summernote({
    height: 200,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: false                 // set focus to editable area after initializing summernote
});
$(document).on('click', '.addImage', function (e) {
    console.log('addImage');
    var html = '';
    html = '<tr id="image-row' + myLabel.imageRow + '">';
    html += '  <td class="text-left"><a href="" type="image" id="thumb-image' + myLabel.imageRow + '"data-toggle="image" class=""><img src="'+myLabel.placeholder+'" alt="" title="" data-placeholder="'+myLabel.placeholder+'" /></a><input type="hidden" name="images[' + myLabel.imageRow + '][image]" value="" id="input-image' + myLabel.imageRow + '" /></td>';
    html += '  <td class="text-left"><div class="form-group form-focus select-focus"><input type="text" name="images[' + myLabel.imageRow + '][sort_order]" value="" class="form-control" id="input-sort_order' + myLabel.imageRow + '" data-placeholder="Sort Order" required></div></td>';
    html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + myLabel.imageRow + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';

    $('#images tbody').append(html);
    myLabel.imageRow++;
});

/* Dynamic Menu Selction */
/** Select Dynamic Menu*/
$('#menu a[href]').on('click', function() {

    sessionStorage.setItem('menu', $(this).attr('href'));
});

if (!sessionStorage.getItem('menu')) {
    $('#menu #dashboard').addClass('active');
} else {
    // Sets active and open to selected page in the left column menu.
    if (sessionStorage.getItem('menu') != '#') {
        $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').addClass('active');
    }

}

if (localStorage.getItem('sidebar') == 'active') {
    $('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

    $('#sidebar').addClass('active');

    // Slide Down Menu
    $('#menu li.active').has('ul').children('ul').addClass(' in');
    $('#menu li').not('.active').has('ul').children('ul').addClass('');
} else {
    $('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');
    $('#menu li li.active').has('ul').children('ul').addClass(' in');
    $('#menu li li').not('.active').has('ul').children('ul').addClass('');
}

// Menu button
$('#button-menu').on('click', function() {
    // Checks if the left column is active or not.
    if ($('#sidebar').hasClass('active')) {
        localStorage.setItem('sidebar', '');

        $('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

        $('#sidebar').removeClass('active');

        $('#menu > li > ul').removeClass('in collapse');
        $('#menu > li > ul').removeAttr('style');
    } else {
        localStorage.setItem('sidebar', 'active');

        $('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

        $('#sidebar').addClass('active');

        // Add the slide down to open menu items
        $('#menu li.open').has('ul').children('ul').addClass('collapse in');
        $('#menu li').not('.open').has('ul').children('ul').addClass('collapse');
    }
});

// Image Manager
$(document).on('click', 'a[data-toggle=\'image\']', function(e) {
    var $element = $(this);
    //console.log($element);
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
            return '<a type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>';
        }
    });

    $element.popover('show');
    console.log(1);
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
            // }
            var html = '';
            // html = '<option value="">select option</option>';

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


// Global Fetch Data & Delete Data
const $dt               = $("#datatable");
const $deleteBtn        = $("#deleteBtn");

var validate          = ($.fn.validate !== undefined), dataTable         = ($.fn.dataTable !== undefined);


const $frmShopProduct       = $("#frmShopProduct");
// Handbook Form validation
if ($frmShopProduct.length > 0 && validate) {
    $frmShopProduct.validate({
        rules:{
            name: {
                required: true,
            },
            status: {
                required: true,
            },
            quantity: {
                required: true,
            },
            price: {
                required: true,
            },
            meta_title: {
                required: true,
            },
        },
    });
}
// Global Fetch Data & Delete Data
if ($dt.length > 0 && dataTable) {
    var dataTable = $dt.DataTable( {
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
        const id      = $(this).attr('data-id');
        const status  = $(this).val();
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
        $('#agentTable input[type=checkbox]').prop('checked', this.checked);
    });
}
$(document).on('click', '#deleteBtn', function (e) {
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
        console.log(selected);
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
// Global Fetch Data & Delete Data

