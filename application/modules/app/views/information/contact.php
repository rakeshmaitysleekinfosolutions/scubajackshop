<section class="loginpage pb-0">
        <div class="formbox info" >
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-1">
                        <!-- <img src="<?php echo resizeAssetImage('contact-us.png',500,500);?>" alt="" /> -->
                        
                    </div>
                    <div class="col-lg-5 col-md-6" id="my-container">
                        <div class="right-sides frm">
                            <h3>Leave a reply</h3>
                          <!--   <p>Already have a SCUBA JACK Account? <a href="http://localhost/scubajack/login">Sign In</a></p> -->
                            <form id="frm" action="<?php echo base_url('contact');?>" method="post">
                                <div class="form-group register">
                                    <div class="row">
                                        <div class="col form-group register">
                                            <label for="exampleInputEmail1">First Name</label>
                                            <input name="firstname" id="input-firstname" type="text" class="form-control" autocomplete="off" required="" aria-required="true">
                                        </div>
                                        <div class="col form-group register">
                                            <label for="exampleInputEmail1">Last Name</label>
                                            <input name="lastname" id="input-lastname" type="text" class="form-control" autocomplete="off" required="" aria-required="true">
                                        </div>
                                    </div>
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input name="email" id="input-email" type="email" class="form-control" autocomplete="off" required="">
                                    <!--  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --></div>
                                    <div class="form-group register">
                                        <label for="exampleInputPassword1">Website</label>
                                        <input name="website" id="input-website" type="text" class="form-control"  autocomplete="off" required="">
                                    </div>
                                    <div class="form-group register">
                                        <label for="exampleFormControlTextarea1">Write your message here</label>
                                        <textarea class="form-control" id="input-message" name="message" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn submits" id="registerButton" data-loading-text="Loading...">Submit</button> 
                                </form>
                      
                        </div>                       
                    </div>
                     <div class="col-lg-5 col-md-5 pl-0">
                        <div class="contact-left">
                            <h4 class="planheading text-left">Contact us  </h4>
                            
                             <!--  <h2 class="cperson">Beth Costanzo, M Ed</h2>-->
                            <p class="cdetails"><i class="fas fa-map-marker-alt"></i><?php echo getSession('settings')['address_1'];?></p>
                            <?php if(getSession('settings')['address_2']) {?>
                                <p class="cdetails"><i class="fas fa-map-marker-alt"></i><?php echo getSession('settings')['address_2'];?></p>
                            <?php } ?>
                            <h3 class="cphone"><i class="fas fa-phone-volume"></i><?php echo getSession('settings')['phone_1'];?></h3>
                            <?php if(getSession('settings')['phone_2']) {?>
                                <h3 class="cphone"><i class="fas fa-phone-volume"></i><?php echo getSession('settings')['phone_2'];?></h3>
                            <?php } ?>
                            <h6 class="cemail"><i class="fas fa-envelope-open-text"></i><?php echo getSession('settings')['email'];?></h6>
                            <?php if(getSession('settings')['email_2']) {?>
                                <h6 class="cemail2"><?php echo getSession('settings')['email_2'];?></h6>
                            <?php } ?>
                        </div>
                        <div class="client-img">
                            <img src="<?php echo base_url('assets/images/about-us.jpg');?>" alt="" />
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact us page  -->