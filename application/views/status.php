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
                        <li>สถาะนะสินค้า</li>
                    </ul>
                </div>
                <!-- breadcrumbs end-->
                <div style="padding-bottom: 30px;"></div>
                <div class="row">
                <?php if ($order['order_status_id'] == 5 || $order['order_status_id'] == 6): ?>
                     <div class="col-md-12">
                        <p class="text-center">
                            <span class="fa-stack fa-5x">
                              <i class="fa fa-circle fa-stack-2x"></i>
                              <i class="fa fa fa-ban fa-stack-1x fa-inverse"></i>
                            </span>
                            <strong class=""><?php echo $order['status_name']; ?></strong>
                        </p>
                    </div>
                   
                <?php else: ?>
                     <div class="col-md-4">
                        <p class="text-center">
                            <span class="fa-stack fa-5x">
                              <i class="fa fa-circle fa-stack-2x text-success-new"></i>
                              <i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i>
                            </span>
                            <strong class="text-success-new">สั่งซื้อสำเร็จ</strong>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-center">
                            <?php if ($order['order_status_id']>1): ?>
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-success-new"></i>
                                  <i class="fa fa-money fa-stack-1x fa-inverse"></i>
                                </span>
                            <strong class="text-success-new">ชำระเงินสำเร็จ</strong>
                            <?php else: ?>
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x"></i>
                                  <i class="fa fa-money fa-stack-1x fa-inverse" style="color: #FFF;"></i>
                                </span>
                            <strong class="">รอการชำระเงิน</strong>
                            <?php endif ?>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-center">
                            <?php if ($order['order_status_id'] == 4): ?>
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-success-new"></i>
                                  <i class="fa fa-truck fa-stack-1x fa-inverse"></i>
                            </span>
                            <strong class="text-success-new">จัดส่งเรียบร้อย</strong>
                            <?php else: ?>
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x"></i>
                                  <i class="fa fa-truck fa-stack-1x fa-inverse" style="color: #FFF;"></i>
                            </span>
                            <strong class="">รอการจัดส่ง</strong>
                            <?php endif ?>
                        </p>
                    </div>
                    
                <?php endif ?>
                   
                </div>
                <div style="padding-bottom: 30px;"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                เลขที่ใบสั่งซื้อ #<?php echo $order['id']; ?>
                            </h3>
                            </div>
                            <div class="panel-body">
                                <strong>สั่งเมื่อวันที่ <?php echo $order['date']?></strong>
                                <br/>
                                <span>กรุณาชำระเงินภายใน 3 วัน </span>
                                <br/>
                                <br/>
                                <a target="_blank" class="btn btn-default" href="<?php echo base_url('invoice/'.$order['ref_id']) ?>" role="button">
                                 ดูใบสั่งซื้อ
                                </a>

                                <?php if ($order['is_invoice']=="1"): ?>
                                    <p></p>
                                    <a target="_blank" class="btn btn-info" href="<?php echo base_url('fullinvoice/'.$order['ref_id']) ?>" role="button">ใบกำกับภาษี</a>
                                    
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">ที่อยู่สำหรับจัดส่งสินค้า</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    ชื่อ :
                                    <?php echo $order["name"];?>
                                    <br/> ที่อยู่ :
                                    <?php echo $order["address"];?>
                                    <br/> โทร :
                                    <?php echo $order["tel"];?>
                                    <br/> Email:
                                    <?php echo $order["email"];?>
                                    <br/> ประเภทการจัดส่ง :
                                    <?php echo $order["shipping"];?>
                                    <?php if (isset($order["trackpost"])): ?> , tracking:
                                    <?php echo $order["trackpost"];?>
                                    <?php endif ?>
                                </p>
                            </div>
                        </div>
                        <?php if($order['is_tax'] == 1 ) { ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">ที่อยู่สำหรับออกใบกำกับภาษี</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    ชื่อ :
                                    <?php echo $order["name"];?>
                                    <br/> ชื่อบริษัท / ร้าน :
                                    <?php echo $order["tax_company"];?>
                                    <br/> ที่อยู่ :
                                    <?php echo $order["tax_address"];?>
                                    <br/> เบอร์ติดต่อ :
                                    <?php echo $order["tel"];?>
                                    <br/> อีเมล์ :
                                    <?php echo $order["email"];?>
                                    <br/> เลขประจำตัวผู้เสียภาษี:
                                    <?php echo $order["tax_id"];?>
                                </p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-8">
                        <?php if($order['customer_id'] != ""){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>สมาชิก Dealer</h4>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="cart table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Description</th>
                                                <th>Unit price</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($order_detail as $value): ?>
                                            <tr>
                                                <td class="product-img">
                                                    <a href="<?php echo base_url('product/'.$value['slug']) ?>">
                                                <img src="<?php echo $this->config->item('url_img').$value['image']; ?>" alt="" width="100">
                                            </a>
                                                </td>
                                                <td class="cart-description">
                                                    <p>
                                                        <a target="_blank" href="<?php echo base_url(" product/ ".$value['slug']) ?>">
                                                            <?php echo $value['name'] ?>
                                                        </a>
                                                    </p>
                                                    <small>SKU : <span><?php echo $value['sku'] ?></small>
                                                </td>
                                                <td>
                                                    <span class="price">
                                               <?php echo number_format($value['price_order'],2) ?>
                                            </span>
                                                </td>
                                                <td class="product-quantity text-center ">
                                                    <span class="price">
                                                <?php echo $value["quantity"];?>
                                            </span>
                                                </td>
                                                <td>
                                                    <span class="price">
                                                <?php echo number_format($value['price_order']*$value["quantity"],2);?>
                                            </span>
                                                </td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <?php if ($order["is_tax"]): ?>
                                                <td colspan="2" rowspan="4"></td>
                                                <?php else: ?>
                                                 <td colspan="2" rowspan="3"></td>
                                                <?php endif ?>

                                                <td colspan="2">ราคารวมสินค้า</td>
                                                <td colspan="1">
                                                    <span class="price">
                                                        <?php echo number_format($order['total'] - $order['shipping_charge'],2);?>&nbsp;บาท
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php if ($order["is_tax"]): ?>
                                            <tr>
                                                <td colspan="2">VAT</td>
                                                <td colspan="1"><span class="price">
                                                <?php if($order["is_tax"]==0){echo "0.00";}else{echo number_format($order["vat"],2);} ?>&nbsp;บาท
                                            </span></td>
                                            </tr>
                                            <?php endif ?>
                                            <tr>
                                                <td colspan="2">ค่าจัดส่งสินค้า</td>
                                                <td colspan="1"><span class="price"><?php echo number_format($order["shipping_charge"],2);?>&nbsp;บาท</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="total"><span>รวมทั้งหมด</span></td>
                                                <td colspan="1"><span class="total-price"><?php echo number_format($order["total"],2);?>&nbsp;บาท</span></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div style="padding-bottom: 20px;"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">การชำระเงิน</h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php echo $this->config->item('payment_transfer') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div style="padding-bottom: 50px;"></div>
