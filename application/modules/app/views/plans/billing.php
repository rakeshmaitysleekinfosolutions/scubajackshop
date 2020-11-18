<section class="loginpage billing_page">
    <div class="formbox">
        <div class="container">
            <div class="row">
                <div class="col-md-5 pr-0 billing_left">
                    <?php if(isset($plan)) { ?>
                        <div class="plan-billing">
                            <h4 class="planheading"><?php echo $plan->name;?></h4>
                            <h2>$<?php echo $plan->price;?></h2>
                            <p>For <?php echo $plan->frequency_interval;?> <?php echo $plan->frequency;?></p>
                            <h6 class="description"><?php echo $plan->description;?></h6>
                        </div>
                    <?php } ?>
                </div>
          
                <div class="col-md-7 pl-0 billing_right" id="my-container">
                    <div class="billing-form signup-form">
                        <h3 class="text-billing">Billing</h3>
                        <form id="frmSignUp" action="<?php echo base_url('register');?>" method="post">
                            <div class="form-group register">
                                <label for="exampleInputEmail1"></label>
                                <input value="<?php echo userName();?>" type="text" class="form-control" autocomplete="off" readonly>
                                <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --></div>
                            <div class="form-group register">
                                <label for="exampleInputPassword1"></label>
                                <input value="<?php echo userEmail();?>" type="text" class="form-control"  readonly>
                            </div>
                            <!-- <button type="submit" class="btn submits" id="registerButton" data-loading-text="Loading...">Sign Up</button> -->
                        </form>
                    <div class="billingcard">
                        
                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" alt="PayPal acceptance mark">
                        <!-- <a href="https://www.paypal.com/us/webapps/mpp/paypal-popup" class="about_paypal"
                         onclick="javascript:window.open('https://www.paypal.com/us/webapps/mpp/paypal-popup',
                         'WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, 
                         scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">What is PayPal?</a> -->
                            <form id="frmPaypal" method="post">
                                <input type="hidden" name="planId" id="planId" value="<?php echo $plan->paypal_plan_id;?>">
                                <button type="button" class="btn processToPayPal" id="processToPayPal">Process to PayPal</button>
<!--                                <button type="button" class="btn " id="processToPayPal">Process to PayPal</button>-->
                            </form>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</section>
<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
    myLabel.paypal = '<?php echo base_url('processToPayPal');?>';
</script> 