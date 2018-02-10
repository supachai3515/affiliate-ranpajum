<div class="slider-area">

        <div class="bend niceties preview-2">
            <div id="ensign-nivoslider-2" class="slides">
            <?php foreach ($slider_list as $slider): ?>
                <?php if ($slider['id'] < 5): ?>
                    <img src="<?php echo $slider['image'] ?>" alt="" title="#slider-direction-<?php echo $slider['id']; ?>" />
                <?php endif ?>
             <?php endforeach ?>
            </div>
            <?php foreach ($slider_list as $slider): ?>
                <?php if ($slider['id'] < 5): ?>

                  <!-- direction 1 -->
                    <div id="slider-direction-<?php echo $slider['id']; ?>" class="t-cn slider-direction">
                        <div class="slider-progress"></div>
                        <div class="slider-content t-cn s-tb slider-1">
                            <div class="title-container s-tb-c title-compress">
                            <?php if (isset($slider['name']) && $slider['name'] != ""): ?>
                                <h1 class="animated bounceInDown title1"><?php echo $slider['name'] ?></h1>
                            <?php endif ?>
                            <?php if (isset($slider['description'])&& $slider['description'] != ""): ?>
                                <h3 class="title2"><span><?php echo $slider['description'] ?></span></h3>
                            <?php endif ?>
                            <?php if (isset($slider['description1'])&& $slider['description1'] != ""): ?>
                                <p class="desc-layer"> <?php echo $slider['description1'] ?></p>
                            <?php endif ?>
                            <?php if (isset($slider['name_link'])&& $slider['name_link'] != ""): ?>
                                <a href="<?php echo $slider['link'] ?>" class="link"><?php echo $slider['name_link'] ?></a>
                            <?php endif ?>
                            </div>
                        </div>
                    </div>

                <?php endif ?>
             <?php endforeach ?>
        </div>
</div>
<!-- banner-area start-->
<div class="banner-area space-top">
    <div class="container">
        <div class="row">
            <?php foreach ($slider_list as $slider): ?>
                <?php if ($slider['id'] > 5 && $slider['id'] < 9 ) : ?>

                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="single-banner">
                            <a href="<?php echo $slider['link'] ?>">
                                <img src="<?php echo $slider['image'] ?>" alt="<?php echo $slider['name_link'] ?>">
                            </a>
                        </div>
                    </div>

                <?php endif ?>
             <?php endforeach ?>
        </div>
     </div>
</div>
<!-- banner-area end-->
<!-- header-middle-area start -->
<!-- header-middle-area end -->
<section class="slider-category-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-lg-3 col-md-3">
              <?php
                 //left-sidebar
                 $this->load->view('template/left-sidebar');
             ?>
            </div>
            <div class="col-sm-9 col-lg-9 col-md-9">
                    <!--
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="product-header">
                        <div class="area-title">
                            <h2><i class="fa fa-bullhorn" aria-hidden="true"></i> ข่าวสารจาก <?php echo $this->config->item('sitename'); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div style="padding-bottom: 20px;"></div>
                <div class="col-md-12">
                    <div class="row">

                    <?php foreach ($slider_list as $slider): ?>
                        <?php if ($slider['id'] == '9'): ?>
                            <div class="jumbotron">
                                <div class="container">
                                    <h1 style="font-size: 22px;"><?php echo $slider['name'] ?></h1>
                                    <p><?php echo $slider['description'] ?></p>
                                    <p>
                                        <a class="btn btn-default btn-lg" href="<?php echo $slider['link'] ?>"><?php echo $slider['name_link'] ?></a>
                                    </p>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                    </div>
                </div>
                <div class="banner-area">
                    <div class="row">
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="single-banner">
                                <a href="<?php echo base_url('tracking');?>">
                                        <img src="<?php echo base_url('theme');?>/img/banner/banner-tacking.png" alt="">
                                    </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="single-banner">
                                <a href="<?php echo base_url('howtobuy');?>">
                                        <img src="<?php echo base_url('theme');?>/img/banner/howtobuy.png" alt="">
                                    </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="single-banner">
                                <a href="<?php echo base_url('warranty');?>">
                                        <img src="<?php echo base_url('theme');?>/img/banner/warranty.png" alt="">
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
                -->
                <!-- banner-area end-->

                <!-- new-arrival-tab-area start-->
                <div class="product-tab-area-3">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="product-header">
                                <div class="area-title">
                                    <h2>สินค้าใหม่</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-area">
                        <div class="row">
                            <div class="tab-content">
                                <!-- sports-tab-start -->
                                <?php
                                    $data['product_list']= $product_new;
                                    $this->load->view('template/home-newarrival',$data);
                                ?>
                                <!-- sports-tab-end -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- new-arrival-tab-area end-->

                <!-- new-arrival-tab-area start-->
                <div class="product-tab-area-3">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="product-header">
                                <div class="area-title">
                                    <h2> สินค้าขายดี</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-area">
                        <div class="row">
                            <div class="tab-content">
                                <!-- sports-tab-start -->
                                <?php
                                    $data['product_list']= $product_hot;
                                    $this->load->view('template/home-popular',$data);
                                ?>
                                <!-- sports-tab-end -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- new-arrival-tab-area end-->

                <!-- new-arrival-tab-area start-->
                <div class="product-tab-area-3">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="product-header">
                                <div class="area-title">
                                    <h2>ลดราคา</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-area">
                        <div class="row">
                            <div class="tab-content">
                                <!-- sports-tab-start -->
                                <?php
                                    $data['product_list']= $product_promotion;
                                    $this->load->view('template/home-popular',$data);
                                ?>
                                <!-- sports-tab-end -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- new-arrival-tab-area end-->
                <!-- new-arrival-tab-area start-->
                <div class="product-tab-area-3">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="product-header">
                                <div class="area-title">
                                    <h2>แนะนำ</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-area">
                        <div class="row">
                            <div class="tab-content">
                                <!-- sports-tab-start -->
                                <?php
                                    $data['product_list']= $product_sale;
                                    $this->load->view('template/home-popular',$data);
                                ?>
                                <!-- sports-tab-end -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- new-arrival-tab-area end-->

            </div>
        </div>
    </div>
</section>
<?php $this->load->view('template/logo'); ?>
