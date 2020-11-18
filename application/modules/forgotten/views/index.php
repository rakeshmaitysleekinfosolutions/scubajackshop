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
            <div class="col-md-4 pl-0"  id="my-container">
               <div class="right-side fogotten-form">
                  <h3>Forgot Password</h3>
                  <p>Need a new password? Let's get you a new one. Enter your email below to continue.</p>
                  <form id="frmForgotten" method="post">
                  <input type="hidden" name="<?php echo __token();?>" value="<?php echo csrf_token();?>">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Email Address</label>
                        <input name="email" id="email" type="email" class="form-control" required>
                        <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --></div>
                     <a class="btn submit" href="<?php echo url('login');?>">Back to Sign In</a>
                     <button type="submit" class="btn submit" id="forgottenButton" data-loading-text="Loading...">Next</button>
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
    myLabel.forgotten = '<?php echo url('forgotten');?>';
 </script>