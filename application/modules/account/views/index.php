<section class="dashboard-wrapper">
    <div class="container">
      <div class="dash-area">
        <div class="row">
          <div class="col-md-4">
            <div class="tabs">
              <ul class="nav flex-column">
                <li><a href="#home" data-toggle="tab">Dashboard</a></li>
                  <li><a href="#passport" data-toggle="tab">Passport</a></li>
                <li class="active"><a href="#Orders" data-toggle="tab">Orders</a></li>
<!--                <li><a href="#download" data-toggle="tab">Downloads</a></li>-->
                <li ><a href="#account-details" data-toggle="tab">Account Details</a></li>
                <li><a href="#log-out" data-toggle="tab" onclick="return logout();">Log out</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-8">
            <div class="tab-content">
              <div class="tab-pane " id="home">
                  <p>Hello <span>user</span> (not you? <a href="#">Log out</a>)</p>
                  <h2>You have already subscribed <?php echo (isset($plan['name'])) ? $plan['name'] : '';?> plan</h2>
                  <p>Price: $<?php echo (isset($plan['price'])) ? $plan['price'] : '';?></p>
                  <h3>Expire Date: <?php echo (isset($plan['end_at'])) ? $plan['end_at'] : '';?></h3>
                  <h3>Day Left: <?php echo (isset($plan['daysLeft'])) ? $plan['daysLeft'] : '';?></h3>
                  <h6 class="description"><?php echo (isset($plan['description'])) ? $plan['description'] : '';?></h6>
                  <p>Subscriber Name: <?php echo (isset($subscriber['name'])) ? $subscriber['name'] : '';?></p>
                  <h3>Subscriber Email: <?php echo (isset($subscriber['email'])) ? $subscriber['email'] : '';?></h3>
              </div>
              <div class="tab-pane active" id="Orders">

                  <?php if(count($orders) > 0) { ?>
                      <div class="details flup" id="my-container">
                          <?php $index = 1;foreach ($orders as $order) { ?>
                            <p><?php echo $index;?>. Order Id- <spn><?php echo $order['order_id'];?></spn>|
                            Order Status- <spn><?php echo $order['status'];?></spn>|
                            Order Date- <spn><?php echo $order['date'];?></spn>|
                            Total Amount- <spn><?php echo $order['total'];?></spn></p>
                          <?php $index++;} ?>
                      </div>
                  <?php } ?>
              </div>
<!--              <div class="tab-pane" id="download">-->
<!--                <div class="order-box border-left-blue"> <i class="far fa-check-circle"></i>-->
<!--                  <p>No download has been made yet-->
<!--                    <button type="button" class="btn browse-products">Browse products</button>-->
<!--                  </p>-->
<!--                </div>-->
<!--              </div>-->

              <div class="tab-pane " id="account-details">
                <div class="details flup" id="my-container">
                  <h3>Account Details</h3>
                  <form id="frm" class="frm" action="<?php echo base_url('account/update');?>" method="post">
                       <div class="row">
                         <div class="col-sm-6">
                           <div class="form-group account">
                            <label for="inputAddress">First name</label>
                            <input value="<?php echo $user->firstname;?>" id="firstname" name="firstname" type="text" class="form-control" placeholder="First name" required>
                          </div>
                         </div>
                         <div class="col-sm-6">
                           <div class="form-group account">
                            <label for="inputAddress">Last name</label>
                            <input value="<?php echo $user->lastname;?>" id="lastname" name="lastname" type="text" class="form-control" placeholder="Last name" required>
                          </div>
                         </div>                           
                       </div>
                       <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group account">
                          <label for="input-gender">Gender</label>
                          <select name="gender" id="input-gender" class="form-control">
                              <option value="">select gender</option>
                              <option value="Male" <?php echo ($user->gender == 'Male') ? "selected" : "";?>>Male</option>
                              <option value="Female" <?php echo ($user->gender == 'Female') ? "selected" : "";?>>Female</option>
                          </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group account">
                              <label for="Guardian">Guardian</label>
                              <input type="text" id="input-guardian" name="guardian" class="form-control" value="<?php echo $user->guardian;?>">
                           </div>
                        </div>
                       </div>
                      
                       <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group account">
                              <label for="inputAddress">Email Address</label>
                              <input value="<?php echo $user->email;?>" id="email" name="email" type="text" class="form-control"  placeholder="example@mail.com" required readonly>
                          </div>
                        </div>  
                        <div class="col-sm-6">
                          <div class="form-group account">
                              <label for="inputAddress">Phone</label>
                              <input value="<?php echo $user->phone;?>" id="phone" name="phone" type="text" class="form-control" placeholder="1234567896" required>
                          </div>
                        </div>                        
                       </div>
                     
                       <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group account">
                            <label for="inputAddress">New Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group account ">
                            <label for="inputAddress">Confirm New password</label>
                            <input type="password" id="confirm" name="confirm" class="form-control">
                          </div>
                        </div>
                        </div>
                       <div class="form-group account">
                          <!-- <label for="input-gender">Upload Profile Picture</label> -->
                          <a href="javascript:void(0);" id="thumb-image" data-toggle="image" class="img-thumbnail" type="image"><img src="<?php echo $thumb;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>"/></a>
                          <input type="hidden" name="image" value="<?php echo $image;?>" id="input-image" />
                      </div>
                       <button id="btn" type="submit" class="btn savechanges">Update Profile</button>
                  </form>

                </div>
              </div>
              <div class="tab-pane" id="passport">
                                        <div class="blue-box">
                                          <div class="row">
                                            <div class="col-md-6 box_left">
                                              <h2>The adventures of scuba jack</h2>
                                              <h3>Virtual Field Trips</h3>
                                             
                                              <div class="container">
                                                <div class="row">
                                                  <div class="col-md-4 image">
                                                    <h4>Picture of student:</h4>
                                                    <img src="<?php echo ($user->image) ? resize($user->image,100,100) : resize('no_image.png',100,100);?>" alt="<?php echo $user->firstname. " ". $user->lastname;?>">
                                                  </div>
                                                  <div class="col-md-4 details">
                                                    <label for="name">Name of student:</label>
                                                    <p><?php echo $user->firstname." ".$user->lastname;?></p>
                                                    <label for="id">ID Number:</label>
                                                    <p><?php echo $user->uuid;?></p>
                                                  </div>
                                                  <div class="col-md-4 details">
                                                    <label for="gender">Gender:</label>
                                                    <p>Male</p>
                                                    <label for="guardian">Guardian:</label>
                                                    <p><?php echo $user->guardian;?></p>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-6 box_right">
                                              <div class="row">
                                                <div class="col-md-8">
                                                  <h3>Completed Virtual Field Trips:</h3>
                                                </div>
                                              </div>  
                                              <div class="col-md-8 logo_right">
                                                  <img src="<?php echo resize(getSession('settings')['logo'],90,50);?>" alt="<?php echo getSession('settings')['company_name'];?>">
                                                </div>
                                              
                                              <div class="container">
                                                <div class="row">
                                                  <div class="col-md-12">
                                                      <?php if($passports) { ?>
                                                        <ul class="continents">
                                                            <?php $i = 1; foreach ($passports as $passport) { ?>
                                                                <li><?php echo $i;?>.&nbsp;<?php echo $passport;?></li>
                                                            <?php $i++;} ?>
                                                        </ul>
                                                      <?php } ?>
                                                  </div>
                                                </div>
                                              </div>
                                              <h5>Points Earned</h5>
                                              <label for="number"><?php echo $points;?></label>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
              <div class="tab-pane" id="log-out" >
                <p>Hello <span>user</span> (not you? <a href="javascript:void(0);" onclick="return logout();">Log out</a>)</p>
                <p> From your account dashboard you can view your<a href="#"> recent orders,</a> manage your <a href="#">shipping and billing addresses</a>, and edit your<a href="#"> password and account 
                    </a>details. </p>
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
   myLabel.filemanager = '<?php echo site_url('filemanager');?>';
  
  function logout () {
      window.location.href = '<?php echo base_url('account/logout');?>';
        // return true or false, depending on whether you want to allow the `href` property to follow through or not
    }
</script>