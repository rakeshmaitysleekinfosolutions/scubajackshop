var Card = require("card");
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