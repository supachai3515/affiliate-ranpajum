<div class="tab-pane fade in active">
	<div class="product-carusul-pagination">
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

        <!-- single-product-start -->
		<div class="col-lg-3 col-md-3">
			<div class="single-product">
				<div class="img-area">
					<a href="<?php echo base_url('product/'.$row['slug']) ?>">
						<img alt="<?php echo $row['name']; ?>" src="<?php echo $image_url;?>">
					</a>
					<span class="new-box">
						<span class="new-label">ใหม่</span>
					</span>
					<div class="price-box">
						<?php if ($dis_price < $price): ?>
	                        <span class="new-price" ng-bind="<?php echo $dis_price;?> | currency:'฿':0"></span>
	                        <span class="old-price" ng-bind="<?php echo $price;?> | currency:'฿':0"></span>
	                    <?php else: ?>
	                        <span class="new-price" ng-bind="<?php echo $dis_price;?> | currency:'฿':0"></span>
	                    <?php endif ?>
					</div>
				</div>
				<div class="product-details">
					<h2 class="product-name">
						<a href="<?php echo base_url('product/'.$row['slug']) ?>"><?php echo $row['name']; ?></a>
					</h2>

					<?php if ($row['stock'] > 0): ?>
	                    <div class="button-area">
							<a href="<?php echo base_url('cart/add/'.$row["id"]) ?>"><span>+ สั่งซื้อสินค้า</span></a>
						</div>
	                <?php else: ?>
	 
                        <div class="button-area">
							<a href="<?php echo base_url('product/'.$row['slug']) ?>"><span>+ รายละเอียด</span></a>
						</div>
	                <?php endif ?>
				</div>
			</div>
		</div>
		<!-- single-product-end -->
    <?php $i++;  endforeach ?>
	</div>
</div>
		