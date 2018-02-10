<!-- static-right-social-area end-->
<section class="slider-category-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- breadcrumbs start-->
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="<?php echo base_url(); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>ตะกร้าสินค้า</li>
                    </ul>
                </div>
                <!-- breadcrumbs end-->
                <div style="padding-bottom: 30px;"></div>
                <!-- cart start-->
                <div class="row">
                    <div class="col-lg-12 col-md-12">

                    <?php 
                      if($this->session->flashdata('msg') != ''){
                          echo '
                          <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            '.$this->session->flashdata('msg').'
                          </div>';
                      }   
                  ?>  
                    <?php if ($this->cart->contents()): ?>
                        <?php echo form_open('cart/update_cart'); ?>
                        <div class="cart table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th>Unit price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach($this->cart->contents() as $items): ?>
                                    <?php echo form_hidden('rowid[]', $items['rowid']); ?>
                                    <?php foreach ($cart_list as $row): ?>
                                    <?php if ($row['rowid']== $items['rowid']): ?>
                                    <tr <?php if($i&1){ echo 'class="alt"'; }?>>
                                        <td class="product-img">
                                            <a href="<?php echo base_url('product/'.$row['slug']) ?>">
                                                 <img src="<?php echo $row['img']; ?>" class="img-responsive" alt="" width="100">
                                            </a>
                                        </td>
                                        <td class="cart-description">
                                            <p>
                                                <a href="<?php echo base_url('product/'.$row['slug']) ?>">
                                                    <?php echo $row['name']; ?>
                                                </a>
                                            </p>
                                            <?php if($row['slug']!=''){ echo '<small >SKU : '.$row['sku'].'</small>'; }?>
                                            <small><span class="label label-success">มีสินค้า</span></small>
                                        </td>
                                        <td>
                                            <span class="price"><?php echo $this->cart->format_number($row['price']); ?></span>
                                        </td>
                                        <td>
                                            <input type="text" hidden="true"  name="product_id[]" value="<?php echo $row['id'] ?>">
                                            <?php echo form_input(array('name' => 'qty[]', 'value' => $row['qty'], 'maxlength' => '3', 'size' => '5')); ?>
                                        </td>
                                        <td>
                                            <span class="price"><?php echo $this->cart->format_number($items['subtotal']); ?></span>
                                        </td>
                                        <td>
                                            <p class="text-center">
                                                <a href="<?php echo base_url('cart/delete/'.$row['rowid']) ?>"><i class="fa fa-trash-o" style="color:#a94442"></i></a>
                                            </p>
                                        </td>
                                    </tr>
                                    <?php endif ?>
                                    <?php endforeach ?>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" rowspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="total"><span>รวมทั้งหมด</span></td>
                                        <td colspan="2">
                                            <?php echo $this->cart->format_number($this->cart->total()); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <?php echo form_submit('', 'ปรับปรุงตะกร้าสินค้า');?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php echo form_close();  ?>
                        </div>
                    <?php endif ?>
                        <div class="cart-button">
                            <a href="<?php echo base_url('products') ?>">
                                <i class="fa fa-angle-left"></i> กลับไปเลือกสินค้า
                            </a>
                            <?php if ($this->cart->total() > 0 ): ?>
                                <a class="standard-checkout" href="<?php echo base_url('checkout') ?>">
                                    <span>ยืนยันการสั่งซื้อ <i class="fa fa-angle-right"></i></span>
                                </a>
                            <?php endif ?>
                        </div>
                    </div>
               </div>
                <!-- breadcrumbs end-->
            </div>
        </div>
    </div>
</section>
<div style="padding-bottom: 50px;"></div>
