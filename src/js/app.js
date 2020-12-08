window.Popper = require('popper.js').default;
window.$ = global.$ = window.jQuery = require('jquery');
//import './jquery-ui-1.12.1/jquery-ui';
// Remove Cart
// $(document).on('click','.remove',function() {
//     var cart_id    = $(this).attr("id");
//     swal("Are you sure you want to remove this item?", {
//         buttons: {
//             cancel: "Cancel",
//             catch: {
//                 text: "Remove",
//                 value: "remove",
//             }
//         },
//     })
//         .then((value) => {
//             switch (value) {
//                 case "remove":
//                     $.ajax({
//                         url : myLabel.remove,
//                         method : "POST",
//                         data : {cart_id : cart_id},
//                         dataType: 'json',
//                         success :function(json){
//                             if (json['success']) {
//                                 //$('#ShowCart').html(res.data);
//                                 // $('#ShowCart').load(myLabel.cartShowUrl);
//                                 $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
//                                 window.location.href = json['redirect'];
//                             }
//                         }
//                     });
//                     break;
//                 default:
//                     //swal("Got away safely!");
//             }
//         });
//
//
// });
//
// // Buy Now
// $('.buy-now').on('click', function() {
//     const quantity = $(this).attr('data-quantity');
//     const product_id = $(this).attr('data-product_id');
//     $.ajax({
//         url: myLabel.cart,
//         type: 'POST',
//         data: {
//             quantity: quantity,
//             product_id: product_id,
//         },
//         cache: false,
//         dataType: 'json',
//         success: function(json) {
//             if (json['success']) {
//                 $('#cart > a').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
//                 window.location.href= myLabel.baseUrl + '/checkout/cart';
//             }
//         },
//         error: function(xhr, ajaxOptions, thrownError) {
//             alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
//         }
//     });
// });
// // Add to Cart
// $('.add-to-cart').on('click', function() {
//     const quantity = $(this).attr('data-quantity');
//     const product_id = $(this).attr('data-product_id');
//     $.ajax({
//         url: myLabel.cart,
//         type: 'POST',
//         data: {
//             quantity: quantity,
//             product_id: product_id,
//         },
//         cache: false,
//         dataType: 'json',
//         success: function(json) {
//             if (json['success']) {
//                 $('.breadcrumb').after('<div class="alert alert-success alert-dismissible">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
//                 $('#cart > a').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
//             }
//         },
//         error: function(xhr, ajaxOptions, thrownError) {
//             alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
//         }
//     });
// });
// // Update Cart
// $(document).on('click','.update-cart',function(e) {
//     //e.preventDefault();
//     $.ajax({
//         url : $('#frmCart').attr('action'),
//         method : "POST",
//         data : $('#frmCart').serialize(),
//         dataType: 'json',
//         success :function(json){
//             if (json['success']) {
//                 $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
//                 window.location.href = json['redirect'];
//             }
//         }
//     });
// });
// // Add to Wishlist
// $('.add-to-wishlist').on('click', function() {
//     const product_id = $(this).attr('data-product_id');
//     $.ajax({
//         url: myLabel.wishlist,
//         type: 'POST',
//         data: {
//             product_id: product_id,
//         },
//         cache: false,
//         dataType: 'json',
//         success: function(json) {
//             if (json['success']) {
//                 $('#wishlist-total span').html(json['totalWishListed']);
//                 $('#wishlist-total').attr('title', json['totalWishListed']);
//             }
//         },
//         error: function(xhr, ajaxOptions, thrownError) {
//             alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
//         }
//     });
// });
// $(document).on('click','.remove-wishlist',function() {
//     var shop_id    = $(this).attr("shop_id");
//     swal("Are you sure you want to remove this item?", {
//         buttons: {
//             cancel: "Cancel",
//             catch: {
//                 text: "Remove",
//                 value: "remove",
//             }
//         },
//     })
//         .then((value) => {
//             switch (value) {
//                 case "remove":
//                     $.ajax({
//                         url : myLabel.removeWishlist,
//                         method : "POST",
//                         data : {shop_id : shop_id},
//                         dataType: 'json',
//                         success :function(json){
//                             if (json['success']) {
//                                 //$('#ShowCart').html(res.data);
//                                 // $('#ShowCart').load(myLabel.cartShowUrl);
//                                 //$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
//                                 window.location.href = json['redirect'];
//                             }
//                         }
//                     });
//                     break;
//                 default:
//                 //swal("Got away safely!");
//             }
//         });
//
//
// });
//
//
// $(document).ready(function(){
//     var quantitiy=0;
//     $('.quantity-right-plus').click(function(e){
//         // Stop acting like a button
//         var cart_id = $(this).attr('data-cart_id');
//         e.preventDefault();
//         // Get the field name
//         var quantity = parseInt($('#quantity_'+cart_id).val());
//         //console.log("+"+quantity);
//         // If is not undefined
//         $('#quantity_'+cart_id).val(quantity + 1);
//         // Increment
//     });
//     $('.quantity-left-minus').click(function(e){
//         var cart_id = $(this).attr('data-cart_id');
//
//         // Stop acting like a button
//         e.preventDefault();
//         // Get the field name
//         var quantity = parseInt($('#quantity_'+cart_id).val());
//         //console.log("-"+quantity);
//         // If is not undefined
//         // Increment
//         if(quantity == 1 ){
//             return false;
//         }
//         if(quantity>0){
//             $('#quantity_'+cart_id).val(quantity - 1);
//         }
//
//     });
//
// });
