<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if lt IE 7 ]> <html lang="en" class="ie6">    <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7">    <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8">    <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9">    <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $header['description'];?>">
    <meta name="keyword" content="<?php echo $header['keyword'];?>" />
    <meta name="author" content="<?php echo $header['author'];?>">
    <meta property="fb:app_id" content="204742923362459"/>
    <title><?php echo $header['title']; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('theme');?>/img/favicon-2.ico">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,600" type="text/css" media="all" />
    <link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Athiti|Kanit|Prompt:300" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url('theme');?>/datepicker/css/bootstrap-datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/datepicker/css/bootstrap-timepicker.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/owl.theme.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/owl.transitions.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/meanmenu.min.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/jquery-ui.min.css">
     <!-- Add fancyBox Css-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('theme');?>/fancyBox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('theme');?>/fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('theme');?>/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/custom-slider/css/nivo-slider.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/custom-slider/css/preview.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/style.css">
    <link rel="stylesheet" href="<?php echo base_url('theme');?>/css/responsive.css">
    <script src="<?php echo base_url('theme');?>/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body class="home-3" ng-app="myApp" ng-controller="mainCtrl">
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
                                    <i class="fa fa-phone"></i> 087-8809644
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-12 hidden-sm hidden-xs col-md-4">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="top-menu">
                                <nav>
                                    <ul>
                                        <li class="current"><a href="<?php echo base_url('dealer')?>"><i class="fa fa-user" aria-hidden="true"></i> Dealer</a></li>
                                        <li><a href="https://www.facebook.com/xcitehiteccom-259231204578178/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i> FB</a></li>
                                        <li><a href="http://line.me/ti/p/%40xcitehitec">LINE : @xcitehitec</a></li>
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
                                <a href="<?php echo base_url()?>">
                                    <img src="<?php echo base_url('theme');?>/img/logo/logo-1.png" alt="">
                                </a>
                            </div>
                        </div>
                        <!-- logo end -->
                        <!-- search-box start -->
                        <div class="col-sm-6 col-xs-12 col-md-5">
                            <div style="margin-top: -10px">
                                <form class="navbar-form ng-pristine ng-valid" role="search" action="<?php echo base_url('search')?>" method="GET">
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
                                    <?php
                                        $productResult = array();
                                        $productResult  = $this->initdata_model->get_cart_data();
                                        $sumItems = 0;
                                        foreach ($productResult  as $r) {
                                            $sumItems = $sumItems + $r['qty'];
                                        }
                                     ?>
                                        <a href="<?php echo base_url('cart') ?>">
                                            <b>ตะกร้าสินค้า</b>
                                            <span class="item">
                                            <span ><?php echo $sumItems; ?></span> - ชิ้น
                                            <span class="total-amu">
                                                <span><?php echo $this->cart->format_number($this->cart->total()); ?></span>
                                            </span>
                                            </span>
                                        </a>

                                        <?php if ($this->cart->contents()): ?>
                                            <div class="mini-cart-content">

                                            <?php $i = 1; ?>
                                            <?php foreach($this->cart->contents() as $items): ?>
                                                <?php echo form_hidden('rowid[]', $items['rowid']); ?>
                                                <?php foreach ($productResult as $row): ?>
                                                    <?php if ($row['rowid']== $items['rowid']): ?>
                                                        <div class="cart-img-details" >
                                                            <div class="cart-img-photo">
                                                                <a href="<?php echo base_url('product/'.$row['slug']) ?>">
                                                                    <img src="<?php echo $row['img']; ?>" alt="" />
                                                                </a>
                                                            </div>
                                                            <div class="cart-img-contaent">
                                                                <a href="<?php echo base_url('product/'.$row['slug']) ?>"  ><h4  ng-bind="item.name"></h4></a>
                                                                <span class="quantity"><?php echo $row['qty'] ?> ชิ้น</span>
                                                                <span><?php echo $row['price'] ?> </span>
                                                            </div>
                                                            <div class="pro-del">
                                                                <a href="<?php echo base_url('cart/delete/'.$row['rowid']) ?>"><i class="fa fa-times-circle"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>


                                                    <?php endif ?>
                                                <?php endforeach ?>
                                        <?php $i++; ?>
                                        <?php endforeach; ?>
                                            <div class="cart-inner-bottom">
                                                <p class="total">รวม: <span class="amount" style="color: #fff;"><?php echo $this->cart->format_number($this->cart->total()); ?></span></p>
                                                <div class="clear"></div>
                                                <p class="buttons"><a href="<?php echo base_url('checkout') ?>">ยันยันการสั่งซื้อ</a></p>
                                            </div>
                                        </div>
                                        <?php endif ?>

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
                                    <li><a href="<?php echo base_url()?>"><i class="fa fa-home"></i></a></li>
                                    <li><a href="<?php echo base_url('products')?>">สินค้า</a></li>
                                     <li><a href="<?php echo base_url('howtobuy')?>">ช่วยเหลือ</a>
                                        <ul class="sub-menu">
                                           <li><a href="<?php echo base_url('howtobuy')?>">วิธีการสั่งซื้อ</a></li>
                                           <li><a href="<?php echo base_url('tracking')?>">การจัดส่ง</a></li>
                                           <li><a href="<?php echo base_url('warranty')?>">การรับประกัน</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="<?php echo base_url('payment')?>">แจ้งชำระเงิน</a></li>
                                    <li><a href="<?php echo base_url('tracking')?>">ติดตามสินค้า</a></li>
                                    <li><a href="<?php echo base_url('contact')?>">ติดต่อเรา</a></li>
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
                                    <li><a href="<?php echo base_url()?>"><i class="fa fa-home"></i></a></li>
                                    <li><a href="<?php echo base_url('products')?>">สินค้า</a></li>
                                     <li><a href="#">ช่วยเหลือ</a>
                                        <ul>
                                           <li><a href="<?php echo base_url('howtobuy')?>">วิธีการสั่งซื้อ</a></li>
                                           <li><a href="<?php echo base_url('tracking')?>">การจัดส่ง</a></li>
                                           <li><a href="<?php echo base_url('warranty')?>">การรับประกัน</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="<?php echo base_url('payment')?>">แจ้งชำระเงิน</a></li>
                                    <li><a href="<?php echo base_url('tracking')?>">ติดตามสินค้า</a></li>
                                    <li><a href="<?php echo base_url('contact')?>">ติดต่อเรา</a></li>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area end -->
    </header>
