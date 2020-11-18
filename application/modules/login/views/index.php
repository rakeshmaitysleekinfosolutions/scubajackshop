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
               <div class="right-side signin-form">
                  <h3>Sign in</h3>
                  <p>New to Scubajack? <a href="<?php echo base_url('register');?>">Sign Up</a></p>
                  <form id="frmSignIn" action="<?php echo url('login');?>" method="post">
                  <input type="hidden" name="<?php echo __token();?>" value="<?php echo csrf_token();?>">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input name="identity" id="identity" type="text" class="form-control" autocomplete="off" required>
                        <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --></div>
                     <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input name="password" id="password" type="password" class="form-control" autocomplete="off" required>
                     </div>
                     <div class="form-check pt-4">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember" <?php if(isset($_COOKIE["remember_me"])) { ?> checked <?php } ?>>
                        <label class="form-check-label" for="exampleCheck1">Remember me</label>
                     </div>
                     <div class="col-md-6">
                        <a href="<?php echo url('forgotten');?>" class="forgoat-password-link">Forgot Password?</a>
                     </div>
                     
                     <button type="submit" class="btn submits" id="logInButton" data-loading-text="Loading...">Log In</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

