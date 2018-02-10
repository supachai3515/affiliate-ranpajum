<?php
/**
 * The Header for our theme.
 * Displays all of the <head> section and everything up till <div id="content">
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<?php zerif_top_head_trigger(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
<link rel="shortcut icon" type="image/x-icon" href="http://www.cyberbatt.com/theme/img/favicon-2.ico">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,600" type="text/css" media="all" />
    <link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Athiti|Kanit|Prompt:300" rel="stylesheet">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/owl.carousel.css">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/owl.theme.css">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/owl.transitions.css">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/animate.css">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/meanmenu.min.css">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/jquery-ui.min.css">
     <!-- Add fancyBox Css-->
        <link rel="stylesheet" type="text/css" href="http://www.cyberbatt.com/theme/fancyBox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
        <link rel="stylesheet" type="text/css" href="http://www.cyberbatt.com/theme/fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
        <link rel="stylesheet" type="text/css" href="http://www.cyberbatt.com/theme/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/normalize.css">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/custom-slider/css/nivo-slider.css" type="text/css" />
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/custom-slider/css/preview.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/main.css">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/style.css">
    <link rel="stylesheet" href="http://www.cyberbatt.com/theme/css/responsive.css">
    <script src="http://www.cyberbatt.com/theme/js/vendor/modernizr-2.8.3.min.js"></script>
      <style type="text/css">
        body.custom-background {
            background-image: none;
            
        }
    </style>
</head>

<?php if(isset($_POST['scrollPosition'])): ?>

	<body <?php body_class(); ?> onLoad="window.scrollTo(0,<?php echo intval($_POST['scrollPosition']); ?>)">

<?php else: ?>

	<body <?php body_class(); ?> >

<?php endif;

	zerif_top_body_trigger();
	
	/* Preloader */

	if(is_front_page() && !is_customize_preview() && get_option( 'show_on_front' ) != 'page' ):
 
		$zerif_disable_preloader = get_theme_mod('zerif_disable_preloader');
		
		if( isset($zerif_disable_preloader) && ($zerif_disable_preloader != 1)):
			echo '<div class="preloader">';
				echo '<div class="status">&nbsp;</div>';
			echo '</div>';
		endif;	

	endif; ?>
<div id="mobilebgfix"  class="home-3" ng-app="myApp" ng-controller="mainCtrl">

    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- Add your site or application content here -->
<header>
    <div class="header-container">
            <!-- header-top-area start -->
            <div class="header-top-area">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="currency">
                                <span class="menu-lavel">
                                    <i class="fa fa-phone"></i> 091-7824565
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-12 hidden-sm hidden-xs col-md-4">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="top-menu">
                                <nav>
                                    <ul>
                                        <li class="current"><a href="http://www.cyberbatt.com/dealer"><i class="fa fa-user" aria-hidden="true"></i> Dealer</a></li>
                                        <li><a href="https://www.facebook.com/cyberbatt/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i> FB</a></li>
                                        <li><a href="http://line.me/ti/p/%40cyberbatt">LINE : @cyberbatt</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-top-area end -->
            <!-- header-bottom-area start -->
            <div class="header-bottom-area">
                <div class="container">
                    <div class="row">
                        <!-- logo start -->
                        <div class="col-sm-6 col-xs-12 col-md-3">
                            <div class="logo">
                                <a href="http://www.cyberbatt.com/">
                                    <img src="http://www.cyberbatt.com/theme/img/logo/logo-1.png" alt="">
                                </a>
                            </div>
                        </div>
                        <!-- logo end -->
                        <!-- search-box start -->
                        <div class="col-sm-6 col-xs-12 col-md-5">
                            <div style="margin-top: -10px">
                                <form class="navbar-form ng-pristine ng-valid" role="search" action="http://www.cyberbatt.com/search" method="GET">
                                    <div class="input-group search-form">
                                        <input type="text" class="form-control" placeholder="ค้นหาสินค้า" name="search" style="font-size: 18px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- search-box end -->

                        <!-- shopping-cart start -->
                        <div class="col-sm-12 col-xs-12 col-md-4">
                            <div class="shopping-cart">
                                <ul>
                                    <li>
                                                                            <a href="http://www.cyberbatt.com/cart">
                                            <b>ตะกร้าสินค้า</b>
                                            <span class="item">
                                            <span >0</span> - ชิ้น
                                            <span class="total-amu">
                                                <span></span>
                                            </span>
                                            </span>
                                        </a>
      
                                        
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- shopping-cart end -->
                    </div>
                </div>
            </div>
            <!-- header-bottom-area end -->
        </div>
        <!-- main-menu-area start -->
        <div class="main-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li><a href="http://www.cyberbatt.com/"><i class="fa fa-home"></i></a></li>
                                    <li><a href="http://www.cyberbatt.com/products">สินค้า</a></li>
                                     <li><a href="http://www.cyberbatt.com/howtobuy">ช่วยเหลือ</a>
                                        <ul class="sub-menu">
                                           <li><a href="http://www.cyberbatt.com/howtobuy">วิธีการสั่งซื้อ</a></li>
                                           <li><a href="http://www.cyberbatt.com/tracking">การจัดส่ง</a></li>
                                           <li><a href="http://www.cyberbatt.com/warranty">การรับประกัน</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="http://www.cyberbatt.com/payment">แจ้งชำระเงิน</a></li>
                                    <li><a href="http://www.cyberbatt.com/tracking">ติดตามสินค้า</a></li>
                                    <li><a href="http://www.cyberbatt.com/faq">ถาม-ตอบ</a></li>
                                    <li><a href="http://www.cyberbatt.com/content/">บทความ</a></li>
                                    <li><a href="http://www.cyberbatt.com/contact">ติดต่อเรา</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-menu-area end -->
        <!-- mobile-menu-area start -->
        <div class="mobile-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mobile-menu">
                            <nav id="dropdown">
                                 <ul>
                                    <li><a href="http://www.cyberbatt.com/"><i class="fa fa-home"></i></a></li>
                                    <li><a href="http://www.cyberbatt.com/products">สินค้า</a></li>
                                     <li><a href="#">ช่วยเหลือ</a>
                                        <ul>
                                           <li><a href="http://www.cyberbatt.com/howtobuy">วิธีการสั่งซื้อ</a></li>
                                           <li><a href="http://www.cyberbatt.com/tracking">การจัดส่ง</a></li>
                                           <li><a href="http://www.cyberbatt.com/warranty">การรับประกัน</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="http://www.cyberbatt.com/payment">แจ้งชำระเงิน</a></li>
                                    <li><a href="http://www.cyberbatt.com/tracking">ติดตามสินค้า</a></li>
                                    <li><a href="http://www.cyberbatt.com/faq">ถาม-ตอบ</a></li>
                                    <li><a href="http://www.cyberbatt.com/content/">บทความ</a></li>
                                    <li><a href="http://www.cyberbatt.com/contact">ติดต่อเรา</a></li>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area end -->
    </header>