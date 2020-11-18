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
               <div class="right-side reset-form">
                  <h3>Forgot Password</h3>
                  <p>Set up a new password and get back to accessing all the best in story books, activity books and others.</p>
                  <form id="frmReset" method="post" action="<?php echo ($action) ? $action : '';?>">
                  <input type="hidden" name="<?php echo __token();?>" value="<?php echo csrf_token();?>">
                     <div class="form-group">
                        <label for="exampleInputEmail1">New Password</label>
                        <input name="password" id="password" type="password" class="form-control" autocomplete="off" required>
                        <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --></div>
                     <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input name="confirm" id="confirm" type="password" class="form-control" autocomplete="off" required>
                     </div>
                     <button type="submit" class="btn submit" id="resetButton" data-loading-text="Loading...">Reset Password</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>