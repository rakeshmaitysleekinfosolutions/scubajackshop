// window.Popper = require('popper.js').default;
// window.$ = global.$ = window.jQuery = require('jquery');
// //import './jquery-ui-1.12.1/jquery-ui';
// require('./additional-methods');
// require('./jquery.validate');
// require('./loadingoverlay.min');
var Card = require("card");
//import * as Card from "card";

$( document ).ready(function() {
    var headerVideolinkDiv = $('.headerVideoLink');
    if(headerVideolinkDiv.length != 0) {
        headerVideolinkDiv.magnificPopup({
            type:'inline',
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        })
    }
}).on('click', '.headerVideoLink', function() {
    var headerVideolinkDiv = $('.headerVideoLink');
    if($(this).length != 0) {
        var subscriberId = $(this).attr('data-subscriberId');
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            dataType: "json",
            data: {
                subscriberId: subscriberId
            },
            beforeSend: function() {
                $.LoadingOverlay("show");
            },
            cache: false,
            success: function (data) {
                if (!data['success']) {
                    setTimeout(function() {
                        location.href = data['redirect'];
                    },3000);
                } else {
                    setTimeout(function() {
                        headerVideolinkDiv.magnificPopup({
                            type:'inline',
                            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
                        })
                        $.LoadingOverlay("hide");
                    },3000);
                }
            },error: function (err) {
                console.log(err);
            }
        });
    }
});

var quiz = $('#quiz');
if (quiz.length !=0 ) {
    fetch(myLabel.fetchQuizData)
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
           // console.log(data);
        $('#quiz').quiz({
            //resultsScreen: '#results-screen',
            counter: true,
            //homeButton: '#custom-home',
            counterFormat: 'Question %current of %total',
            questions: data,
            backUrl: myLabel.baseUrl,
            answerCallback: function (currentQuestion, selected, question) {
                $.ajax({
                    type: "POST",
                    url: myLabel.userGivenAnswer,
                    dataType: "json",
                    data: {
                        question: question.id,
                        answer: question.answerId,
                    },
                    cache: false,
                    success: function (data) {

                    },error: function (err) {
                        console.log(err);
                    }
                });
            },
            finishCallback: function (score, numQuestions) {
                $.ajax({
                    type: "POST",
                    url: myLabel.finishCallback,
                    dataType: "json",
                    data: {
                        quiz: myLabel.quizName,
                        score: score,
                        numQuestions: numQuestions,
                    },
                    cache: false,
                    success: function (data) {

                    },error: function (err) {
                        console.log(err);
                    }
                });
            }
        });
    })
}

    //$quiz.quiz({});


function download(filename) {
    if (typeof filename==='undefined') filename = ""; // default
    value = document.getElementById('textarea_area').value;

    filetype="text/*";
    extension=filename.substring(filename.lastIndexOf("."));
    for (var i = 0; i < extToMIME.length; i++) {
        if (extToMIME[i][0].localeCompare(extension)==0) {
            filetype=extToMIME[i][1];
            break;
        }
    }


    var pom = document.createElement('a');
    pom.setAttribute('href', 'data: '+filetype+';charset=utf-8,' + '\ufeff' + encodeURIComponent(value)); // Added BOM too
    pom.setAttribute('download', filename);


    if (document.createEvent) {
        if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) { // IE
            blobObject = new Blob(['\ufeff'+value]);
            window.navigator.msSaveBlob(blobObject, filename);
        } else { // FF, Chrome
            var event = document.createEvent('MouseEvents');
            event.initEvent('click', true, true);
            pom.dispatchEvent(event);
        }
    } else if( document.createEventObject ) { // Have No Idea
        var evObj = document.createEventObject();
        pom.fireEvent( 'onclick' , evObj );
    } else { // For Any Case
        pom.click();
    }

}
function downloadURL(url) {
    var hiddenIFrameID = 'hiddenDownloader',
        iframe = document.getElementById(hiddenIFrameID);
    if (iframe === null) {
        iframe = document.createElement('iframe');
        iframe.id = hiddenIFrameID;
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
    }
    iframe.src = url;
};

var map = $('#map');
var paths = $('.map__image a');

if(map.length != 0) {
    if(NodeList.prototype.forEach == undefined) {
        NodeList.prototype.forEach = function (callback) {
            [].forEach().call(this, callback);
        }
    }
    // $("#map").mapify({
    //     popOver: {
    //         content: function(path){
    //             return "<strong>"+path.attr("xlink:title")+"</strong>";
    //         },
    //         delay: 0.7,
    //         margin: "15px",
    //         height: "130px",
    //         width: "260px"
    //     }
    // });
    //MAP TOOLTIPS SCRIPT
    //var tooltipNum = ['#nova-scotia', '#new-brunswick']

    $(paths).qtip({
        content: function() {
            return $( this ).data('tooltip'); //store data in data-tooltip
        },
        position: {
            my: 'bottom center',  // Position my top left...
            at: 'top center', // at the bottom right of...
            adjust: {
                y: 10
            }
        },
        style: {
            tip: {
                corner: true,
                corner: 'bottom center',
                border: 1,
                width: 15,
                height: 7
            }
        }
    });
    paths.each(function (path) {

        $(this).on("click", function(){
            var countryIso      = $(this).attr('data-iso');
            var subscriberId    = $(this).attr('data-subscriberid');

            var formData = new FormData();
            formData.append('userId', subscriberId);
            formData.append('countryIso', countryIso);

            $.ajax({
                type: "POST",
                url: $(this).attr('data-url'),
                dataType: "json",
                data: {
                    subscriberId: subscriberId
                },
                beforeSend: function() {
                    $.LoadingOverlay("show");
                },
                cache: false,
                success: function (res) {
                    if (res['success']) {
                        stampToPassport({data: formData});

                    } else {
                        setTimeout(function() {
                            location.href = myLabel.viewplans;
                        },3000);
                    }
                },error: function (err) {
                    console.log(err);
                }
            });

            function stampToPassport(options) {
                fetch(myLabel.stampToPassport, {
                    method: 'post',
                    body: options.data
                }).then(function(response) {
                    return response.json();
                }).then(function (data) {
                    var success = data.success;
                    if(success) {
                        console.log(success);
                        setTimeout(function() {
                            location.href = data.redirect;
                        },3000);
                    } else {
                        setTimeout(function() {
                            location.href = data.redirect;
                        },3000);
                    }

                });
            }
        });
    })




}
$(document).ready(function(){
    var imageGallery = $('#imageGallery');
    var videoGallery = $('#videoGallery');
    var activityBooks = $('.activityBooks');
    if(imageGallery.length != 0) {
        $('#imageGallery').lightGallery();
    }
    if(videoGallery.length != 0) {
        $('#videoGallery').lightGallery();
    }
    if(activityBooks.length != 0) {
        $('.activityBooks').lightGallery();
    }
});



/* Update JS */
$(document).on('click','.remove',function() {
    var cart_id    = $(this).attr("id");
    swal("Are you sure you want to remove this item?", {
        buttons: {
            cancel: "Cancel",
            catch: {
                text: "Remove",
                value: "remove",
            }
        },
    })
        .then((value) => {
            switch (value) {
                case "remove":
                    $.ajax({
                        url : myLabel.remove,
                        method : "POST",
                        data : {cart_id : cart_id},
                        dataType: 'json',
                        success :function(json){
                            if (json['success']) {
                                //$('#ShowCart').html(res.data);
                                // $('#ShowCart').load(myLabel.cartShowUrl);
                                $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                                window.location.href = json['redirect'];
                            }
                        }
                    });
                    break;
                default:
                //swal("Got away safely!");
            }
        });


});

// Buy Now
$('.buy-now').on('click', function() {
    const quantity = $(this).attr('data-quantity');
    const product_id = $(this).attr('data-product_id');
    $.ajax({
        url: myLabel.cart,
        type: 'POST',
        data: {
            quantity: quantity,
            product_id: product_id,
        },
        cache: false,
        dataType: 'json',
        success: function(json) {
            if (json['success']) {
                $('#cart > a').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                window.location.href= myLabel.baseUrl + 'cart';
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
// Add to Cart
$('.add-to-cart').on('click', function() {
    const quantity = $(this).attr('data-quantity');
    const product_id = $(this).attr('data-product_id');
    $.ajax({
        url: myLabel.cart,
        type: 'POST',
        data: {
            quantity: quantity,
            product_id: product_id,
        },
        cache: false,
        dataType: 'json',
        success: function(json) {
            if (json['success']) {
                $('.breadcrumb').after('<div class="alert alert-success alert-dismissible">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                $('#cart > a').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
// Update Cart
$(document).on('click','.update-cart',function(e) {
    //e.preventDefault();
    $.ajax({
        url : $('#frmCart').attr('action'),
        method : "POST",
        data : $('#frmCart').serialize(),
        dataType: 'json',
        success :function(json){
            if (json['success']) {
                $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                window.location.href = json['redirect'];
            }
        }
    });
});
// Add to Wishlist
$('.add-to-wishlist').on('click', function() {
    const product_id = $(this).attr('data-product_id');
    var $btn = $(this);
    console.log($btn);
    $.ajax({
        url: myLabel.wishlist,
        type: 'POST',
        data: {
            product_id: product_id,
        },
        cache: false,
        dataType: 'json',

        success: function(json) {
            if (json['success']) {
                if(json['remove']) {
                    $('a[data-product_id="' + product_id + '"] > i.whishstate').removeClass('red_icon');
                    $('a[data-product_id="' + product_id + '"] > i.whishstate').removeClass('blur_icon');
                } else {
                    $('a[data-product_id="' + product_id + '"] > i.whishstate').removeClass('blur_icon');
                    $('a[data-product_id="' + product_id + '"] > i.whishstate').addClass('red_icon');
                }
                //$btn.LoadingOverlay("hide");
                $('#wishlist-total span').html(json['totalWishListed']);
                $('#wishlist-total').attr('title', json['totalWishListed']);
            } else {
                //$btn.LoadingOverlay("hide");
                window.location.href = json['redirect'];
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
$(document).on('click','.remove-wishlist',function() {
    var shop_id    = $(this).attr("data-shop_id");
    console.log(shop_id);
    swal("Are you sure you want to remove this item?", {
        buttons: {
            cancel: "Cancel",
            catch: {
                text: "Remove",
                value: "remove",
            }
        },
    })
        .then((value) => {
            switch (value) {
                case "remove":
                    $.ajax({
                        url : myLabel.removeWishlist,
                        method : "POST",
                        data : {shop_id : shop_id},
                        dataType: 'json',
                        success :function(json){
                            if (json['success']) {
                                //$('#ShowCart').html(res.data);
                                // $('#ShowCart').load(myLabel.cartShowUrl);
                                //$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                                window.location.href = json['redirect'];
                            }
                        }
                    });
                    break;
                default:
                //swal("Got away safely!");
            }
        });


});


$(document).ready(function(){
    var quantitiy=0;
    $('.quantity-right-plus').click(function(e){
        // Stop acting like a button
        var cart_id = $(this).attr('data-cart_id');
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity_'+cart_id).val());
        //console.log("+"+quantity);
        // If is not undefined
        $('#quantity_'+cart_id).val(quantity + 1);
        // Increment
    });
    $('.quantity-left-minus').click(function(e){
        var cart_id = $(this).attr('data-cart_id');

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity_'+cart_id).val());
        //console.log("-"+quantity);
        // If is not undefined
        // Increment
        if(quantity == 1 ){
            return false;
        }
        if(quantity>0){
            $('#quantity_'+cart_id).val(quantity - 1);
        }

    });
    var current = 0,
        $preview = $( '#preview' ),
        $carouselEl = $('#carousel');

    if($carouselEl.length != 0) {
        var $carouselItems = $carouselEl.children(),
            carousel = $carouselEl.elastislide( {
                current : current,
                minItems : 4,
                onClick : function( el, pos, evt ) {
                    changeImage( el, pos );
                    evt.preventDefault();
                },
                onReady : function() {
                    changeImage( $carouselItems.eq( current ), current );
                }
            } );
    }

    function changeImage( el, pos ) {
        $preview.attr( 'src', el.data( 'preview' ) );
        $carouselItems.removeClass( 'current-img' );
        el.addClass( 'current-img' );
        carousel.setCurrent( pos );
    }
});
// Payment Address
$('select[name="payment_address[country_id]"]').on('change', function() {
    var country_id = $('select[name="payment_address[country_id]"]').find(":selected").val();
    console.log(country_id);
    $.ajax({
        url: myLabel.states,
        dataType: 'json',
        method: 'POST',
        data: {
            country_id: country_id
        },
        beforeSend: function() {
            $('select[name="payment_address[country_id]"]').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
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

            $('select[name="payment_address[state_id]"]').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
$('select[name="payment_address[country_id]"]').trigger('change');
// Shipping Address
$('select[name="shipping_address[country_id]"]').on('change', function() {
    var country_id = $('select[name="shipping_address[country_id]"]').find(":selected").val();
    $.ajax({
        url: myLabel.states,
        dataType: 'json',
        method: 'POST',
        data: {
            country_id: country_id
        },
        beforeSend: function() {
            $('select[name="shipping_address[country_id]"]').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
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

            $('select[name="shipping_address[state_id]"]').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
$('select[name="shipping_address[country_id]"]').trigger('change');

$('#ship-different-address-chkbox').on('change', function(){
    $shippingAddress = $('#shiiping-address');
    $shippingAddress.toggle();
})

$('#submit-payment-address-btn').on('click', function() {

})


var $formBillingAddress = $("#billing-address"),
    validate = ($.fn.validate !== undefined);
var $paymentBtn = $("#payBtn");
if ($formBillingAddress.length > 0 && validate) {
    $formBillingAddress.validate({
        rules:{
            "payment_address[firstname]": {
                required: true,
            },
            "payment_address[lastname]": {
                required: true,
            },
            "payment_address[address_1]": {
                required: true,
            },
            "payment_address[city]": {
                required: true,
            },
            "payment_address[postcode]": {
                required: true,
            },
            "payment_address[country_id]": {
                required: true,
            },
            "payment_address[state_id]": {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: $(form).serialize(),
                beforeSend: function() {
                    $paymentBtn.LoadingOverlay("show");
                },
                success: function (json) {
                    console.log(json);
                    $paymentBtn.LoadingOverlay("hide");
                    window.location.href = json['redirect'];
                }
            });
            return false; // required to block normal submit since you used ajax
        }

    });
}
var $paymentFrm = $('#paymentFrm'),
validate = ($.fn.validate !== undefined);

if ($paymentFrm.length > 0 && validate) {
    $paymentFrm.validate({
        rules:{
            number: {
                required: true,
            },
            exp: {
                required: true,
            },
            cvc: {
                required: true,
            }
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: $(form).serialize(),
                beforeSend: function() {
                    $.LoadingOverlay("show");
                },
                success: function (json) {
                    window.location.href = json['redirect'];
                }
            });
            return false; // required to block normal submit since you used ajax
        }

    });
}
if ($paymentFrm.length > 0) {
    new Card({ 
        form: "form#paymentFrm",
        container: ".card-wrapper",
        formSelectors: { 
          numberInput: "input#cc-number",
          expiryInput: "input#cc-exp",
          cvcInput: "input#cc-cvc",
        },
        width: 270,
        formatting: true,
        placeholders: {
          number: "xxxx xxxx xxxx xxxx",
          cvc: "xxxx"
        },
        masks: {
            cardNumber: '•' // optional - mask card number
        },
        messages: {
          validDate: 'expire\ndate',
          monthYear: 'mm/yy'
      }
      });
}



