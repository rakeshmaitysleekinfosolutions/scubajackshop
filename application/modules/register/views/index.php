<section class="loginpage">
   <div class="formbox">
      <div class="container">
         <div class="row">
            <div class="col-md-8 pr-0">
               <div class="left">
                  <!-- <h3>Subscribe with us</h3>
                  <p>where The World And Reading Colide Each booklet come with activities,video's and quizzes.</p> -->
                  <div class="logo"> <img src="<?php echo base_url('assets/images/scuba-logo.png');?>"> </div>
               </div>
            </div>
            <div class="col-md-4 pl-0" id="my-container">
               <div class="right-sides signup-form ">
                  <h3>Register with us</h3>
                  <p>Already have a SCUBA JACK Account? <a href="<?php echo base_url('login');?>">Sign In</a></p>
                  <form id="frmSignUp" action="<?php echo base_url('register');?>" method="post">
                     <input type="hidden" name="<?php echo __token();?>" value="<?php echo csrf_token();?>">
                     <div class="row">
                        <div class="col form-group register">
                           <label for="exampleInputEmail1">First Name</label>
                           <input name="firstname" id="input-payment-firstname" type="text" class="form-control"  autocomplete="off" required>
                        </div>
                        <div class="col form-group register">
                           <label for="exampleInputEmail1">Last Name</label>
                           <input name="lastname" id="input-payment-lastname" type="text" class="form-control" autocomplete="off" required>
                        </div>
                     </div>
                        <div class="form-group register">
                           <label for="exampleInputEmail1">Email address</label>
                           <input name="email" id="input-payment-email" type="text" class="form-control" autocomplete="off" required>
                           <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --></div>
                        <div class="form-group register">
                           <label for="exampleInputPassword1">Password</label>
                           <input name="password" id="input-payment-password" type="password" class="form-control" placeholder="*******" autocomplete="off" required>
                        </div> 
                     
                        <div class="form-group register">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input name="confirm" id="input-payment-confirm" type="password" class="form-control" placeholder="*******" autocomplete="off" required>
                     <div class="form-check pt-4">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="agree" value="1" required>
                        <label class="form-check-label" for="exampleCheck1">I Agree</label>
                     </div>
                     
                     <button type="submit" class="btn submits" id="registerButton" data-loading-text="Loading...">Sign Up</button>
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