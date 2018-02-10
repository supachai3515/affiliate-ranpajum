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
                    <div class="line hidden-xs"></div>
                    <div class="col-sm-10 col-sm-offset-2 text-center">
                        <?php if ($order['po_order_status_id'] == 8 || $order['po_order_status_id'] == 9): ?>
                        <div class="col-sm-10">
                            <span class="glyphicon-status fa fa-ban"></span>
                            <h4><?php echo $order['status_name']; ?></h4>
                        </div>
                        <?php else: ?>
                        <div class="col-sm-2">
                            <span class="glyphicon-status fa fa-file-o glyphicon-active"></span>
                            <h4>ขอใบเสนอราคาสำเร็จ</h4>
                        </div>
                        <div class="col-sm-2">
                            <?php if ($order['po_order_status_id']>1): ?>
                            <span class="glyphicon-status fa fa-check-circle-o glyphicon-active"></span>
                            <h4>ยืนยันใบเสนอราคาสำเร็จ</h4>
                            <?php else: ?>
                            <span class="glyphicon-status fa fa-check-circle-o"></span>
                            <h4>รอการตวจสอบ</h4>
                            <?php endif ?>
                        </div>
                        <div class="col-sm-2">
                            <?php if ($order['is_invoice']): ?>
                            <span class="glyphicon-status fa fa-file-text-o glyphicon-active"></span>
                            <h4>ออกใบสั่งซื้อสำเร็จ</h4>
                            <?php else: ?>
                            <span class="glyphicon-status fa fa-file-text-o"></span>
                            <h4>รอออกใบสั่งซื้อ</h4>
                            <?php endif ?>
                        </div>
                        <div class="col-sm-2">
                            <?php if ($order['po_order_status_id']>4): ?>
                            <span class="glyphicon-status fa fa-money glyphicon-active"></span>
                            <h4>ชำระเงินเรียบร้อย</h4>
                            <?php else: ?>
                            <span class="glyphicon-status fa fa-money"></span>
                            <h4>รอการชำระเงิน </h4>
                            <?php endif ?>
                        </div>
                        <div class="col-sm-2">
                            <?php if ($order['po_order_status_id']==7): ?>
                            <span class="glyphicon-status fa fa-paper-plane-o glyphicon-active"></span>
                            <h4>จัดสั่งแล้ว</h4>
                            <?php else: ?>
                            <span class="glyphicon-status fa fa-paper-plane-o"></span>
                            <h4>รอการจัดส่ง</h4>
                            <?php endif ?>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
                <div style="padding-bottom: 30px;"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                <?php if ($order['is_invoice']): ?>
                                    เลขที่ใบสั่งซื้อ #<?php echo $order['invoice_docno']; ?>
                                <?php else: ?>
                                   เลขที่ใบเสนอราคา #<?php echo $order['id']; ?>
                                <?php endif ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <?php if ($order['is_invoice']): ?>
                                <strong>ขอใบเสนอราคาวันที่ <?php echo $order['date']?></strong>
                                <br/>
                                <strong>ออกใบสั่งซื้อวันที่ <?php echo $order['invoice_date']?></strong>
                                <br/>
                                <span>กรุณาชำระเงินภายใน 3 วัน </span>
                                <br/>
                                <br/>
                                <a target="_blank" class="btn btn-default" href="<?php echo base_url('po_invoice/'.$order['ref_id']) ?>" role="button">
                                     ดูใบสั่งซื้อ
                                    </a>
                                <?php else: ?>
                                <strong>ขอใบเสนอราคาวันที่ <?php echo $order['date']?></strong>
                                <br/>
                                <br/>
                                <a target="_blank" class="btn btn-default" href="<?php echo base_url('po_invoice/'.$order['ref_id']) ?>" role="button">
                                     ดูใบเสนอราคา
                                    </a>
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
                                    <br/> ประเภทการจักส่ง :
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
                                <h4 class="text-center">สมาชิก Dealer</h4>
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
                                                    <a href="<?php echo base_url('product/'.$value['id']) ?>">
                                                <img src="<?php echo $this->config->item('url_img').$value['image']; ?>" alt="">
                                            </a>
                                                </td>
                                                <td class="cart-description">
                                                    <p>
                                                        <a target="_blank" href="<?php echo base_url("product/ ".$value['slug']) ?>">
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
                                                        <?php echo number_format($order['total'] - $order['vat'] - $order['shipping_charge'],2);?>&nbsp;บาท
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
