<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] 	= 'app';
$route['404_override']          = 'PageNotFoundController/index';

$route['home-store']            = 'store/index';
$route['product/(:any)']        = 'store/view/$1';
$route['cart']                  = 'cart/add';
$route['cart/remove']                  = 'cart/remove';
$route['cart/coupon']                  = 'cart/coupon';
$route['checkout/cart']                  = 'cart/index';
$route['checkout/cart/update']                  = 'cart/update';
$route['wishlist/add']                  = 'wishlist/add';
$route['wishlist']                  = 'wishlist/index';
$route['wishlist/remove']                  = 'wishlist/remove';
// Frontend Login Register
$route['register'] 				= 'register';
$route['login'] 				= 'login';
$route['forgotten'] 		    = 'forgotten';
$route['reset'] 		        = 'reset';

$route['translate_uri_dashes']  = FALSE;

//Set Splash Screen
$route['setSplashScreen'] 	    = 'app/setSplashScreen';
$route['index2'] 	            = 'app/index2';

$route['game']                  = 'app/game';
$route['preschool-learning']    = 'app/preschool';
$route['elementary-learning']   = 'app/elementary';


// Membership Plans
$route['viewplans']             = 'app/viewPlans';
$route['plan/(:any)']           = 'app/account/$1';
$route['createAccount']         = 'app/createAccount';

$route['plan/billing/(:any)']   = 'app/billing/$1';
$route['subscribed']            = 'app/subscribed';
$route['pl']                    = 'app/subscribeReturnUrl';
$route['success']               = 'app/success';
$route['failure']               = 'app/failure';
$route['processToPayPal']       = 'app/processToPayPal';
$route['plans']                 = 'app/getPlans';

$route['admin']                 = 'adminDashboard';
$route['admin-login']           = 'adminDashboard/login';
$route['admin-dashboard']       = 'adminDashboard/dashboard/';
$route['admin-logout']          = 'adminDashboard/admin_logout';

// $route['admin'] = 'welcome/index';
$route['all'] 	                = 'app/category';
$route['account'] 	            = 'account';


$route['worksheets'] 	        = 'app/worksheets';

$route['stampToPassport']       = 'app/stampToPassport';
$route['postGems']              = 'app/postGems';

$route['auth/check']            = 'app/checkLogin';

$route['quiz/(:any)']           = 'app/quiz/$1';
$route['api/fetch/quiz/(:num)']       = 'app/fetchQuizData/$1';
$route['api/quiz/userGivenAnswer']       = 'app/userGivenAnswer';
$route['api/quiz/finishCallback']       = 'app/finishCallback';

$route['api/search']       = 'app/search';

$route['filemanager']           = 'filemanager';
$route['(:any)/explore']        = 'app/explore';
$route['(:any)/explore/(:any)']    = 'app/blog/$1/$2';


$route['about'] 	            = 'app/about';
$route['contact'] 	            = 'app/contact';
$route['(:any)'] 	            = 'app/products/$1';


//$route['all'] 	            = 'category/index';



// Update Children Account
$route['account/update']        = 'account/update';








