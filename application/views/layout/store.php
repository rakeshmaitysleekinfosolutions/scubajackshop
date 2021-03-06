<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <title><?php echo $this->template->title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php echo $this->template->meta; ?>
    <!-- Bootstrap CSS -->
    <!-- font-awesome Css -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/images/favicon-16x16.png">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css">
    <link href="<?php echo base_url();?>assets/css/all.min.css" rel="stylesheet" />

    <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/responsive.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/font/font.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/js/lightgallery/css/lightgallery.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/js/twitter-typeahead/css/normalize.min.css">
    <!--    <link type="text/css" rel="stylesheet" href="--><?php //echo base_url();?><!--assets/js/mapify/jquery.mapify.css">-->
    <?php echo $this->template->stylesheet; ?>


</head>

<body>
<div id="app">


<!--    <div class="splash-screen">-->
<!--        <a href="javascript:void(0);" id="splashscreen">-->
<!--            <img src="--><?php //echo base_url('assets/images/splash-bg.jpg');?><!--" alt="" />-->
<!--        </a>-->
<!--    </div>-->

    <header class="menu-area sticky">
        <div class="container">
            <nav class="navbar navbar-expand-lg ">
                <a class="navbar-brand" href="<?php echo base_url();?>"> <img src="<?php echo (getSession('settings')) ? resize(getSession('settings')['logo'],118,66) :  resize(getSession('assets/theme/light/img/scuba-logo.png;',118,66)) ?>"> </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"> <a class="nav-link" href="<?php echo base_url('/');?>">Home <span class="sr-only">(current)</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('about');?>">About us</a> </li>
                        <!--                        <li class="nav-item"> <a class="nav-link" href="--><?php //echo base_url('viewplans');?><!--">Membership</a> </li>-->
                                                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('home-store');?>">Shop</a> </li>
                        <!--                        <li class="nav-item"> <a class="nav-link" href="--><?php //echo base_url('worksheets');?><!--">Worksheets</a> </li>-->
                                                <li class="nav-item"> <a class="nav-link " href="<?php echo base_url('contact');?>">Contact us</a> </li>
                        <!--                        <li class="nav-item"> <a class="nav-link " href="--><?php //echo base_url('game');?><!--">Game</a> </li>-->


                        <li  class="nav-item"><a class="nav-link" href="<?php echo url('/wishlist');?>" id="wishlist-total" title="Wish List (0)"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm hidden-md">Wish List (<?php echo getTotalWishListed();?>)</span></a></li>
                        <li  class="nav-item" id="cart"><a class="nav-link" href="<?php echo url('/cart');?>"><i class="fa fa-shopping-cart"></i> <span id="cart-total"><?php echo getSession('total');?></span></a></li>
<!--                        <li  class="nav-item">-->
<!--                            <div id="cart" class="btn-group btn-block">-->
<!--                                <button type="button" data-toggle="dropdown" data-loading-text="Loading..." class="btn btn-inverse btn-block btn-lg dropdown-toggle"><i class="fa fa-shopping-cart"></i> <span id="cart-total">--><?php //echo getSession('total');?><!--</span></button>-->
<!--                                <ul class="dropdown-menu pull-right">-->
<!--                                    <li>-->
<!--                                        <p class="text-center">Your shopping cart is empty!</p>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </li>-->
                        <form class="form-inline searchsec">
                            <a href="javascript:toggle1();"><i class="fas fa-search"></i> </a>
                            <div id="toggleText1" style="display:none;" class="search_link">

                                <input class="Typeahead-hint type-hidden" type="text" tabindex="-1" readonly >
                                <input class="form-control Typeahead-hint js-typeahead" placeholder="Search here..." name="q" autofocus autocomplete="off">
                                <!--                            <input type="button" value="Search"/>-->
                            </div>
                        </form>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user"></i><span class="hidden-xs hidden-sm hidden-md"> My Account</span>
                            </a>
                            <?php if(isLogged()) {?>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?php echo url('account');?>">My Account</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="return logout();"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                                </div>
                            <?php } else { ?>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?php echo url('login');?>">Login</a>
                                    <a class="dropdown-item" href="<?php echo url('register');?>">Register</a>
                                </div>
                            <?php } ?>
                        </li>
                    </ul>

                </div>
            </nav>
        </div>
    </header>
    <?php echo $this->template->content; ?>
    <!-------------------------adventure part end----------------->
    <footer class="footer_area">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer_item">
                    <div class="logo"> <img src="<?php echo base_url();?>assets/images/scuba-logo.png"> </div>
                </div>
                <div class="col-md-4 footer_item">
                    <div class="foot-two">
                        <h4>Contact Us</h4>
                        <h5>16 Gibbs Hill Drive, Gloucester, MA. 01930</h5>
                        <h6>berhcostanzo@hotmail.com</h6>
                        <p>Call us at <span>+978-491-0747</span></p>
                    </div>
                </div>
                <div class="col-md-4 footer_item">
                    <div class="foot-three">
                        <h4>Links</h4>
                        <h5>© 2020adventuresofscubajack.com All rights reserved</h5>
                        <li> Terms & Privacy Policy |
                        <li>
                        <li> Warranty-Promise | </li>
                        <li>
                            <?php if(isLogged()) {?>
                                <a href="<?php echo base_url('account');?>">My Account</a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('login');?>">My Account</a>
                            <?php } ?>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <input type="hidden" class="btn btn-primary" data-toggle="modal" data-target="#myModal"></input>
    <?php if(!getSession('is_logged')) { ?>
        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12"  id="my-container">
                                <div class="right-side signin-form">
                                    <h3>Sign in</h3>
                                    <p>New to Scubajack? <a href="<?php echo base_url('register');?>">Sign Up</a></p>
                                    <form id="logInModalForm" action="<?php echo url('login');?>" method="post">
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

                                        <button type="submit" class="btn submits" id="logInModalButton" data-loading-text="Loading...">Log In</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>
<!-------------------------footer end-------------------------->
<script id="result-template" type="text/x-handlebars-template">
    <div class="ProfileCard u-cf">
        <img class="ProfileCard-avatar" src="{{image}}">
        <div class="ProfileCard-details">
            <div class="ProfileCard-realName">{{name}}</div>
            <div class="ProfileCard-screenName">{{category.name}}</div>
            <!--            <div class="ProfileCard-description">{{description}}</div>-->
        </div>
    </div>
</script>
<script id="empty-template" type="text/x-handlebars-template">
    <div class="EmptyMessage">Your search turned up 0 results.</div>
</script>
<script>
    var myLabel = myLabel || {};
    myLabel.baseUrl = '<?php echo base_url();?>';

    function logout () {
        window.location.href = '<?php echo base_url('account/logout');?>';
        // return true or false, depending on whether you want to allow the `href` property to follow through or not
    }
</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquiry.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/loadingoverlay.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript" src="<?php echo base_url();?>assets/js/lightgallery/js/picturefill.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/lightgallery/js/lightgallery-all.min.js"></script>
<!--<script type="text/javascript" src="--><?php //echo base_url();?><!--assets/js/mapify/jquery.mapify.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.quiz.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.qtip.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/twitter-typeahead/js/handlebars.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/twitter-typeahead/js/jquery.xdomainrequest.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/twitter-typeahead/js/typeahead.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Search.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/additional-methods.js"></script>


<!--<script type="text/javascript" src="--><?php //echo base_url();?><!--assets/js/lightgallery/js/jquery.mousewheel.min.js"></script>-->
<?php echo $this->template->javascript; ?>

 <!-- Stripe.js v3 for Elements -->
<script src="https://js.stripe.com/v2/"></script>
<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/app.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>dist/login.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>dist/payment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>dist/app.js"></script>

<script type="text/javascript">
    function toggle1() {
        var ele = document.getElementById("toggleText1");
        var text = document.getElementById("displayText1");
        $("#toggleText1").slideToggle(300);
    }
</script>
</body>

</html>