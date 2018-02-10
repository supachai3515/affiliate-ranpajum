<!-- grid-product-tab-start -->
<div id="grid" class="tab-pane fade active in">
    <?php $i=1; foreach ($product_list as $row): ?>
        <?php
            $image_url="";
            if($row['image'] != "") {
                $image_url = $this->config->item('url_img').$row['image'];
            }
            else { $image_url = $this->config->item('no_url_img');
            }

            $price = $price = $row["price"];
            $dis_price = $disprice = $row["dis_price"];

            if ($this->session->userdata('is_logged_in') && $this->session->userdata('verify') == "1") {

                if($this->session->userdata('is_lavel1')) {
                    if($row["member_discount_lv1"] > 1){
                        $dis_price = $row["member_discount_lv1"];
                    }
                }
                else {

                    if($row["member_discount"] > 1){
                        $dis_price = $row["member_discount"];
                    }
                }
            }
            if ($dis_price == 0) {
               $dis_price =  $price;
            }
        ?>

   <div class="col-sm-4 col-lg-4 col-md-4">
       <div class="item-product">
           <div class="img-product-item text-center">
                <a href="<?php echo base_url('product/'.$row['slug']) ?>">
                    <img src="<?php echo $image_url;?>" class="img-responsive" alt="<?php echo $row['name']; ?>">
                </a>
           </div>

            <div class="item-product-info">
                <div class="item-product-title">
                    <a href="<?php echo base_url('product/'.$row['slug']) ?>">
                        <?php echo $row['name'] ?>
                        <br/>
                        <?php if (isset($row['model']) && $row['model'] != ""): ?>
                        <small><i class="fa fa-cog" aria-hidden="true"> </i> <?php echo $row['model']; ?></small>
                        <?php endif ?>
                    </a>
                </div>

                <div class="price-box-area">
                    <?php if ($dis_price < $price): ?>
                    <span class="new-price" ng-bind="<?php echo $dis_price;?> | currency:'฿':0"></span>
                    <span class="old-price" ng-bind="<?php echo $price;?> | currency:'฿':0"></span>
                    <?php else: ?>
                    <span class="new-price" ng-bind="<?php echo $dis_price;?> | currency:'฿':0"></span>
                    <?php endif ?>
                </div>


            </div>

            <?php if ($row['stock'] > 0): ?>
                <div class="action-button button-exclusive btncart">
                    <a href="<?php echo base_url('cart/add/'.$row["id"]) ?>" class="add-to-cart">
                        <span>+ สั่งซื้อสินค้า</span>
                    </a>
                </div>
            <?php else: ?>
                 <div class="action-button button-exclusive btncart outof-stock">
                    <a href="<?php echo base_url('product/'.$row['slug']) ?>" class="add-to-cart">
                        <span>หมดชั่วคราว</span>
                    </a>
                </div>
            <?php endif ?>

        </div>
    </div>
    <?php if ($i%3 ==0): ?>
    <div class="clearfix"></div>
    <?php endif ?>
    <?php $i++;  endforeach ?>
</div>
<!-- grid-product-tab-end -->
