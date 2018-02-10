<!-- static-right-social-area end-->
<section class="slider-category-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-lg-3 col-md-3">
            <?php 
                 //left-sidebar
                $data['page']= "product_detail";
                     $this->load->view('template/left-sidebar',$data);
            ?>
            </div>
            <div class="col-sm-9 col-lg-9 col-md-9">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <!-- breadcrumbs start-->
                        <div class="breadcrumb">
                            <ul>
                                <li>
                                    <a href="<?php echo base_url(); ?>">Home</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li><a href="<?php echo base_url('products'); ?>">สินค้า</a> <i class="fa fa-angle-right"></i></li>
                                <li>
                                    <a href="<?php echo base_url('products/category/'.$product_detail['type_slug']) ?>"><?php echo $product_detail['type_name'] ?></a><i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <?php echo $product_detail['name'] ?>
                                </li>
                            </ul>
                        </div>
                        <!-- breadcrumbs end-->
                        <div class="product-description-area product-overview">
                            <div class="row">
                                <div class="col-sm-5 col-lg-5 col-md-5">
                                    <?php if (count($product_images)==0): ?>
                                        <img src="<?php echo $this->config->item('no_url_img');?>" class="img-responsive" alt="Image">
                                    <?php endif ?>
                                    <?php $i= 1; foreach ($product_images as $value): ?>
                                    <?php 
										$image_url="";
										if($value['path'] !=""){
                                            $image_url = $this->config->item('url_img').$value['path'];
                                        }
										else { 
                                            $image_url = $this->config->item('no_url_img');
                                        }
									?>
                                    <?php if ($i==1): ?>
                                        <a class="fancybox-thumb" data-fancybox-group="group" href="<?php echo $image_url;?>">
											<img  width="100%" src="<?php echo $image_url;?>" alt="" /></a>
                                        <br>
                                    <?php else: ?>
                                        <a class="fancybox-thumb" data-fancybox-group="group" href="<?php echo $image_url;?>">
									       <img  width="100px" style="padding: 10px 5px" src="<?php echo $image_url;?>" alt="" /></a>
                                    <?php endif ?>
                                    <?php $i++ ; endforeach ?>
                                </div>
                                <div class="col-sm-7 col-lg-7 col-md-7">
                                    <div class="product-description">
                                        <h1 class="product-name">
										<?php echo $product_detail['name'] ?>
									</h1>
                                        <p class="model-condi">
                                            <span><strong>SKU : </strong></span><span> <?php echo $product_detail['sku'] ?></span>
                                            <br>
                                            <?php if (isset($product_detail['model']) && $product_detail['model'] !=''): ?>
                                            <span><strong>MODEL : </strong></span><span> <?php echo $product_detail['model'] ?></span>
                                            <br>
                                            <?php endif ?>
                                            <?php if (isset($product_detail['brand_name'])  && $product_detail['brand_name'] !=''): ?>
                                            <span><strong>BRAND : </strong></span><span> <a href="<?php echo base_url('products/brand/'.$product_detail['brand_slug']) ?>"><?php echo $product_detail['brand_name'] ?></a></span>
                                            <br>
                                            <?php endif ?>
                                        </p>
                                        <p class="product-desc">
                                            <?php //echo $product_detail['shot_detail'] ?>
                                        </p>
                                        <p class="pquantityavailable">
                                        <?php if ($product_detail['stock'] > 0): ?>
                                            <span class="stock-status">มีสินค้า</span>
                                        <?php else: ?>
                                            <small><span class="label label-default">สินค้าหมดชั่วคราว</span></span></small>
                                        <?php endif ?>
                                           
                                        </p>
                                        <div class="price-box-area">
                                            <?php 
                                                $price = $price = $product_detail["price"];
                                                $dis_price = $disprice = $product_detail["dis_price"];

                                                if ($this->session->userdata('is_logged_in') && $this->session->userdata('verify') == "1") {

                                                    if($this->session->userdata('is_lavel1')) {
                                                        if($product_detail["member_discount_lv1"] > 1){
                                                            $dis_price = $product_detail["member_discount_lv1"];
                                                        }
                                                    }
                                                    else {

                                                        if($product_detail["member_discount"] > 1){
                                                            $dis_price = $product_detail["member_discount"];
                                                        }
                                                    }
                                                }
                                                if ($dis_price == 0) {
                                                    $dis_price =  $price;
                                                }
                                            ?>
                                            <?php if ($dis_price < $price): ?>
                                            <span class="new-price" ng-bind="<?php echo $dis_price;?> | currency:'฿':0"></span>
                                            <span class="old-price" ng-bind="<?php echo $price;?> | currency:'฿':0"></span>
                                            <?php else: ?>
                                            <span class="new-price" ng-bind="<?php echo $dis_price;?> | currency:'฿':0"></span>
                                            <?php endif ?>
                                        </div>
                                        
                                        <div class="action-button button-exclusive">
                                        <?php if ($product_detail['stock'] > 0): ?>
                                            <a href="<?php echo base_url('cart/add/'.$product_detail["id"]) ?>" class="add-to-cart">
                                                <span>+ สั่งซื้อสินค้า</span>
                                            </a>
                                        <?php endif ?>
                                        </div>
                                    
                                        
                                        <div class="btn-group" style="padding-bottom:10px;">
                                            <div class="shere-button">
                                                <a href="https://twitter.com/home?status=<?php echo base_url('product/'.$product_detail['slug']) ?>" target="_blank">
                                                    <i class="fa fa-twitter"></i> Tweet
                                                </a>

                                                <a href="https://www.facebook.com/sharer/sharer.php?u="<?php echo base_url('product/'.$product_detail['slug']); ?>" target="_blank">
                                                    <i class="fa fa-facebook"></i> Share
                                                </a>
                                                <a href="https://plus.google.com/share?url=<?php echo base_url('product/'.$product_detail['slug']) ?>" target="_blank">
                                                    <i class="fa fa-google-plus"></i> Google+
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product-overview-start -->
                        <div class="product-overview">
                            <div class="product-overview-tab-menu">
                                <ul>
                                    <li class="active"><a href="#moreinfo" data-toggle="tab">รายละเอียด</a></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div id="moreinfo" class="tab-pane fade in active">
                                    <div class="rte">
                                        <p>
                                            <?php if (isset($product_detail['detail'])  && $product_detail['detail'] !=''): ?>
                                            <?php echo $product_detail['detail'] ?>
                                            <?php endif ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product-overview-end -->
                    </div>
                </div>
            </div>
        </div>
</section>
<?php $this->load->view('template/logo'); ?>
