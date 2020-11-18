<section class="loginpage sub_page">
    <div class="formbox subpage">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-6 pr-0 sub_left">
                    <div class="plan">
                        <?php if(isset($plan)) { ?>
                            <div class="price-box-two">
                                <h4 class="planheading"><?php echo $plan->name;?></h4>
                                <h2>$<?php echo $plan->price;?></h2>
                                <p>For <?php echo $plan->frequency_interval;?> <?php echo $plan->frequency;?></p>
                                <h6 class="description"><?php echo $plan->description;?></h6>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 pl-0 sub_right" id="my-container">
                    <div class="account-rightside  createAccountFrm ">
                        <h3 class="accounts">Create an account</h3>
                        <p>Already have a SCUBA JACK Account? <a href="<?php echo base_url('login');?>">Sign In</a></p>
                        <form id="frm" action="<?php echo base_url('createAccount');?>" method="post">
                            <input type="hidden" name="<?php echo __token();?>" value="<?php echo csrf_token();?>">
                            <input type="hidden" name="slug" value="<?php echo $plan->slug;?>">
                            <div class="row">
                                <div class="col form-group register">
                                    <label for="exampleInputEmail1">First Name</label>
                                    <input name="firstname" id="firstname" type="text" class="form-control"  autocomplete="off" required>
                                </div>
                                <div class="col form-group register">
                                    <label for="exampleInputEmail1">Last Name</label>
                                    <input name="lastname" id="lastname" type="text" class="form-control" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group register">
                                <label for="exampleInputEmail1">Email address</label>
                                <input name="email" id="email" type="text" class="form-control" autocomplete="off" required>
                                <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --></div>
                            <div class="form-group register">
                                <label for="exampleInputPassword1">Password</label>
                                <input name="password" id="password" type="password" class="form-control" placeholder="*******" autocomplete="off" required>
                            </div>
                            <button type="submit" class="btn submits" id="createAccountBtn" data-loading-text="Loading...">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';
</script>