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

        <div class="single-product-bought">
            <div class="image-area">
                <a href="<?php echo base_url('product/'.$row['slug']) ?>">
                    <img alt="<?php echo $row['name']; ?>" src="<?php echo $image_url;?>">
                </a>
            </div>
            <div class="product-info">
                <h2 class="product-name">
                    <a href="<?php echo base_url('product/'.$row['slug']) ?>"><?php echo $row['name']; ?></a>
                </h2>
                <div class="price-box-area">
                    <?php if ($dis_price < $price): ?>
                        <span class="new-price" ng-bind="<?php echo $dis_price;?> | currency:'฿':0"></span>
                        <span class="old-price" ng-bind="<?php echo $price;?> | currency:'฿':0"></span>
                    <?php else: ?>
                        <span class="new-price" ng-bind="<?php echo $dis_price;?> | currency:'฿':0"></span>
                    <?php endif ?>
                </div>
                <?php if ($row['stock'] > 0): ?>
                    <div class="action-button">
                        <a class="add-to-cart" href="<?php echo base_url('cart/add/'.$row["id"]) ?>">
                            <span>+ สั่งซื้อสินค้า</span>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="action-button">
                        <a href="<?php echo base_url('product/'.$row['slug']) ?>" class="add-to-cart">
                            <span>รายละเอียด</span>
                        </a>
                    </div>
                <?php endif ?>

            </div>
        </div>

    <?php $i++;  endforeach ?>
</div>
<!-- grid-product-tab-end -->