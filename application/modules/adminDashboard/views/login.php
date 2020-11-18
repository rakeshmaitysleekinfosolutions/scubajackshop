<!DOCTYPE html>
<html>
    
<!-- Mirrored from dreamguys.co.in/smarthr/light/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 22 Mar 2018 04:11:25 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
        <title>Login - HRMS admin template</title>
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/theme/light/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/theme/light/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/theme/light/css/style.css">
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body>
        <div class="main-wrapper">
			<div class="account-page">
				<div class="container">
                    <h3 class="account-title">Management Login</h3>
                    
					<div class="account-box">
						<div class="account-wrapper">
                            
							<div class="account-logo">
								<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/theme/light/img/scuba-logo.png" alt="Focus Technologies"></a>
                            </div>
                             <?php if($this->session->flashdata('succ')){ ?>
                                <div class="alert alert-success alert-2" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo $this->session->flashdata('succ'); ?>
                                </div>
                            <?php } ?>
                            <?php if($this->session->flashdata('err')){ ?>
                                <div class="alert alert-danger alert-2" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('err'); ?>
                                </div>
                            <?php } ?>
							<form action = "<?php echo base_url('admin-login'); ?>" method="post" id="admin_login_form">
								<div class="form-group form-focus">
									<label class="control-label">Email</label>
									<input class="form-control floating" type="text" name="admin_email">
								</div>
								<div class="form-group form-focus">
									<label class="control-label">Password</label>
									<input class="form-control floating" type="password" name="admin_password">
								</div>
								<div class="form-group text-center">
									<button class="btn btn-primary btn-block account-btn" type="submit" >Log In</button>
								</div>
								<!-- <div class="text-center">
									<a href="forgot-password.html">Forgot your password?</a>
								</div> -->
							</form>
						</div>
					</div>
				</div>
			</div>
        </div>
		<div class="sidebar-overlay" data-reff="#sidebar"></div>
        <script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/app.js"></script>
    </body>

<!-- Mirrored from dreamguys.co.in/smarthr/light/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 22 Mar 2018 04:11:25 GMT -->
</html>