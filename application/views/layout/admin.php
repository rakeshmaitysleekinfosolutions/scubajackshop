<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <?php echo $this->template->meta; ?>

        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>assets/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/images/favicon-16x16.png">
        <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">
        <title>Dashboard - SCUBA JACK Admin</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/theme/light/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/theme/light/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/theme/light/plugins/morris/morris.css">
		
		<link rel="stylesheet" href="<?php echo base_url();?>assets/theme/light/js/sweetalert/sweetalert.css">
		 <link rel="stylesheet" href="<?php echo base_url();?>assets/theme/light/js/summernote/summernote.css">

		<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/theme/light/css/dataTables.bootstrap.min.css"> -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/theme/light/css/select2.min.css">


		<link rel="stylesheet" href="<?php echo base_url();?>assets/theme/light/css/style.css">


		<?php echo $this->template->stylesheet; ?>
	</head>
    <body>
        <div class="main-wrapper">
            <div class="header">
                <div class="header-left">
                    <a href="<?php echo base_url();?>" class="logo">
						<img src="<?php echo base_url();?>assets/theme/light/img/scuba-logo.png" width="64" height="44" alt="">
					</a>
                </div>
                <div class="page-title-box pull-left">
					<h3>SCUBA JACK</h3>
                </div>
				<a id="mobile_btn" class="mobile_btn pull-left" href="#sidebar"><i class="fa fa-bars" aria-hidden="true"></i></a>
				<ul class="nav navbar-nav navbar-right user-menu pull-right">
					<li class="dropdown">
						<a href="profile.html" class="dropdown-toggle user-link" data-toggle="dropdown" title="Admin">
							<span class="user-img"><img class="img-circle" src="<?php echo base_url();?>assets/theme/light/img/user.jpg" width="40" alt="Admin">
							<span class="status online"></span></span>
							<span>Admin</span>
							<i class="caret"></i>
						</a>
						<ul class="dropdown-menu">
							<!-- <li><a href="profile.html">My Profile</a></li>
							<li><a href="edit-profile.html">Edit Profile</a></li>
							<li><a href="settings.html">Settings</a></li> -->
                            <li><a href="<?php echo admin_url('resetpassword'); ?>">Reset Password</a></li>
							<li><a href="<?php echo base_url('admin-logout'); ?>">Logout</a></li>
						</ul>
					</li>
				</ul>
            </div>
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul id="menu">
							<li class="">
								<a href="<?php echo admin_url('dashboard');?>"><i class="fa fa-dashboard fw"></i> Dashboard</a>
							</li>
							<li class="submenu">
								<a href="#" class="noti-dot"><i class="fa fa-user fw"></i><span> Users</span> <span class="menu-arrow"></span></a>
								<ul class="list-unstyled" style="display: none;">
									<li><a href="<?php echo admin_url('users');?>"><i class="fa fa-double-angle-right"></i>Users</a></li>
<!--									<li><a href="--><?php //echo admin_url('users/create');?><!--">Add User</a></li>-->
									<!-- <li><a href="leaves.html"><span>Leave Requests</span> <span class="badge bg-primary pull-right">1</span></a></li>
									<li><a href="attendance.html">Attendance</a></li>
									<li><a href="departments.html">Departments</a></li>
									<li><a href="designations.html">Designations</a></li> -->
								</ul>
							</li>
							<li class="submenu">
								<a href="#" ><i class="fa fa-tags fw"></i><span> Catalog</span><span class="menu-arrow"></span></a>
								<ul class="list-unstyled" style="display: none;">
                                    <li class="categoryplus"><a href="<?php echo admin_url('category');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Categories</span></a></li>
									<li><a href="<?php echo admin_url('product');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Products</span></a></li>
                                    <li><a href="<?php echo admin_url('features_product');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Features Products</span></a></li>
                                    <li><a href="<?php echo admin_url('information');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Information</span></a></li>

								</ul>
							</li>
                            <li class="submenu">
                                <a href="#" ><i class="fa fa-tags fw"></i><span> Quzzies</span><span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li class="categoryplus"><a href="<?php echo admin_url('quiz');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Quzzies</span></a></li>
                                    <li class="categoryplus"><a href="<?php echo admin_url('question');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Questions</span></a></li>
                                    <li><a href="<?php echo admin_url('answer');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Answers</span></a></li>
                                    <li><a href="<?php echo admin_url('userquestionanswer');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>User Results</span></a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#" ><i class="fa fa-tags fw"></i><span> Membership Plan</span><span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li class="categoryplus"><a href="<?php echo admin_url('membershipplan');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Plans</span></a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#" ><i class="fa fa-tags fw"></i><span> Subscribers</span><span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li class="categoryplus"><a href="<?php echo admin_url('subscribers');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Subscribers</span></a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#" ><i class="fa fa-tags fw"></i><span> Virtual Trip</span><span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li class="categoryplus"><a href="<?php echo admin_url('countrydescription');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Manage Content</span></a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#" ><i class="fa fa-tags fw"></i><span> Worksheets</span><span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li class="categoryplus"><a href="<?php echo admin_url('worksheet');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Worksheets</span></a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#" ><i class="fa fa-cog fw"></i> <span>Settings</span><span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li class="categoryplus"><a href="<?php echo admin_url('settings');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Application Settings</span></a></li>
                                    <li class="categoryplus"><a href="<?php echo admin_url('map');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Map</span></a></li>
<!--                                    <li class="categoryplus"><a href="--><?php //echo admin_url('country');?><!--"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Manage Continents</span></a></li>-->
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#" ><i class="fa fa-luggage-cart fw"></i> <span>Shop</span><span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li class="categoryplus"><a href="<?php echo admin_url('shop/category');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Category</span></a></li>
                                    <li class="categoryplus"><a href="<?php echo admin_url('shop/product');?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Products</span></a></li>
                                    <!--                                    <li class="categoryplus"><a href="--><?php //echo admin_url('country');?><!--"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>Manage Continents</span></a></li>-->
                                </ul>
                            </li>
							<!-- <li> 
								<a href="<?php echo base_url('user');?>">Category</a>
							</li> -->
							
							
						</ul>
					</div>
                </div>
            </div>
            <div class="page-wrapper">
					 <?php echo $this->template->content; ?>
			</div>
        </div>
		<div class="sidebar-overlay" data-reff="#sidebar"></div>
       
	    <script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/jquery-3.2.1.min.js" ></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/bootstrap.min.js" ></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/jquery.slimscroll.js" ></script>
<!--		<script type="text/javascript" src="--><?php //echo base_url();?><!--assets/theme/light/plugins/morris/morris.min.js" ></script>-->
		<script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/plugins/raphael/raphael-min.js" ></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/app.js" ></script>

		<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/dataTables.bootstrap.min.js"></script>
	 -->
		<script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/select2.min.js"></script>

		<script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/sweetalert/sweetalert.js" ></script>
		 <script type="text/javascript" src="<?php echo base_url();?>assets/theme/light/js/summernote/summernote.js" ></script>
		<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/App.js" ></script> -->



		<?php echo $this->template->javascript; ?>
		<script>
		// 		var data = [
		// 	  { y: '2014', a: 50, b: 90},
		// 	  { y: '2015', a: 65,  b: 75},
		// 	  { y: '2016', a: 50,  b: 50},
		// 	  { y: '2017', a: 75,  b: 60},
		// 	  { y: '2018', a: 80,  b: 65},
		// 	  { y: '2019', a: 90,  b: 70},
		// 	  { y: '2020', a: 100, b: 75},
		// 	  { y: '2021', a: 115, b: 75},
		// 	  { y: '2022', a: 120, b: 85},
		// 	  { y: '2023', a: 145, b: 85},
		// 	  { y: '2024', a: 160, b: 95}
		// 	],
		// 	config = {
		// 	  data: data,
		// 	  xkey: 'y',
		// 	  ykeys: ['a', 'b'],
		// 	  labels: ['Total Income', 'Total Outcome'],
		// 	  fillOpacity: 0.6,
		// 	  hideHover: 'auto',
		// 	  behaveLikeLine: true,
		// 	  resize: true,
		// 	  pointFillColors:['#ffffff'],
		// 	  pointStrokeColors: ['black'],
		// 		gridLineColor: '#eef0f2',
		// 	  lineColors:['gray','orange']
		//   };
		// config.element = 'area-chart';
		// Morris.Area(config);
		// config.element = 'line-chart';
		// Morris.Line(config);
		// config.element = 'bar-chart';
		// Morris.Bar(config);
		// config.element = 'stacked';
		// config.stacked = true;
		// Morris.Bar(config);
		// Morris.Donut({
		//   element: 'pie-chart',
		//   data: [
		// 	{label: "Employees", value: 30},
		// 	{label: "Clients", value: 15},
		// 	{label: "Projects", value: 45},
		// 	{label: "Tasks", value: 10}
		//   ]
		// });

		/** Select Dynamic Menu*/
        $('#menu a[href]').on('click', function() {

            sessionStorage.setItem('menu', $(this).attr('href'));
        });

        if (!sessionStorage.getItem('menu')) {
            $('#menu #dashboard').addClass('active');
        } else {
            // Sets active and open to selected page in the left column menu.
            if (sessionStorage.getItem('menu') != '#') {
                $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').addClass('active');
            }

        }

        if (localStorage.getItem('sidebar') == 'active') {
            $('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

            $('#sidebar').addClass('active');

            // Slide Down Menu
            $('#menu li.active').has('ul').children('ul').addClass(' in');
            $('#menu li').not('.active').has('ul').children('ul').addClass('');
        } else {
            $('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

            $('#menu li li.active').has('ul').children('ul').addClass(' in');
            $('#menu li li').not('.active').has('ul').children('ul').addClass('');
        }

        // Menu button
        $('#button-menu').on('click', function() {
                    // Checks if the left column is active or not.
                    if ($('#sidebar').hasClass('active')) {
                        localStorage.setItem('sidebar', '');

                        $('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

                        $('#sidebar').removeClass('active');

                        $('#menu > li > ul').removeClass('in collapse');
                        $('#menu > li > ul').removeAttr('style');
                    } else {
                        localStorage.setItem('sidebar', 'active');

                        $('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

                        $('#sidebar').addClass('active');

                        // Add the slide down to open menu items
                        $('#menu li.open').has('ul').children('ul').addClass('collapse in');
                        $('#menu li').not('.open').has('ul').children('ul').addClass('collapse');
                    }
                });
		</script>
    </body>

<!-- Mirrored from dreamguys.co.in/smarthr/light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 22 Mar 2018 04:09:39 GMT -->
</html>