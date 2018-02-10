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
                        <li>ยืนยันการสั่งซื้อ</li>
                    </ul>
                </div>
                <!-- breadcrumbs end-->
                <div style="padding-bottom: 30px;"></div>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                    $productResult = array();
                                    $productResult  = $this->initdata_model->get_cart_data();
                                 ?>
                                <?php foreach($this->cart->contents() as $items): ?>
                                <?php echo form_hidden('rowid[]', $items['rowid']); ?>
                                <?php foreach ($productResult as $row): ?>
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
                                        <span class="price"><?php echo $row['qty']; ?></span>
                                    </td>
                                    <td>
                                        <span class="price"><?php echo $this->cart->format_number($items['subtotal']); ?></span>
                                    </td>
                                </tr>
                                <?php endif ?>
                                <?php endforeach ?>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                            <?php if ($is_tax == 0 ): ?>
                            <tfoot>
                                <tr>
                                    <td colspan="2" rowspan="4"></td>
                                    <td colspan="2">ราคารวมสินค้า</td>
                                    <td colspan="2">
                                        <?php echo $this->cart->format_number($this->cart->total()); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">ค่าจัดส่งสินค้า</td>
                                    <td colspan="2"><span ng-bind="shipping_price + spcial_price | currency:'' "></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="total"><span>รวมทั้งหมด</span></td>
                                    <td colspan="2"><span ng-bind="<?php echo $this->cart->total();?> + shipping_price + spcial_price | currency:'' ">

                                    </td>
                                </tr>
                            </tfoot>
                            <?php else: ?>

                                <tfoot>
                                <tr>
                                    <td colspan="2" rowspan="5"></td>
                                    <td colspan="2">ราคารวมสินค้า</td>
                                    <td colspan="2">
                                        <?php echo $this->cart->format_number($this->cart->total()); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">ภาษีมูลค่าเพิ่ม 7%</td>
                                    <td colspan="2"><?php echo $this->cart->format_number($this->cart->total()*7 /107); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">ค่าจัดส่งสินค้า</td>
                                    <td colspan="2"><span ng-bind="shipping_price + spcial_price | currency:'' "></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="total"><span>รวมทั้งหมด</span></td>
                                    <td colspan="2"><span ng-bind="<?php echo $this->cart->total();?> + shipping_price + spcial_price | currency:'' ">
                                </tr>
                            </tfoot>


                            <?php endif ?>
                        </table>
                        <?php echo form_close();  ?>
                    </div>
                    <div class="cart-button">
                    <?php if ($is_tax == 0 ): ?>
                        <a href="<?php echo base_url('cart') ?>">
                                <i class="fa fa-angle-left"></i> กลับไปแก้ไขสินค้า
                            </a>
                        <a class="standard-checkout" href="<?php echo base_url('checkout/tax') ?>">
                            <span>ออกใบกำกับภาษี <i class="fa fa-file-text-o"></i></span>
                        </a>

                    <?php else: ?>
                      <a href="<?php echo base_url('cart') ?>">
                                <i class="fa fa-angle-left"></i> กลับไปแก้ไขสินค้า
                            </a>
                        <a class="standard-checkout" href="<?php echo base_url('checkout') ?>">
                            <span>ยกเลิกการออกใบกำกับภาษี<i class="fa fa-file-text-o"></i></span>
                        </a>
                    <?php endif ?>
                     </div>
                <?php endif ?>
                <div style="padding-bottom: 30px;"></div>
                <div class="commerce">

                    <div class="head-search">

                        <div class="product-description">
                            <h1 class="text-center product-name">

                            </h1>
                        </div>
                    </div>


                     <form class="form-horizontal form-area" ng-submit="ckeckoutSubmit()"  name="form1" method="post" action="<?php echo base_url('checkout/save'); ?>" OnSubmit="return chkSubmit();">
                               <h2 class="form-heading"> กรุณากรอกรายละเอียดที่อยู่ เพื่อรับสินค้าจากเว็บไซต์</h2>
                              <fieldset>

                              <!-- Multiple Radios -->
                              <div class="form-group " hidden="true">
                                <label class="col-md-4 control-label" for="purchase">รูปแบบการออกใบเสร็จ</label>
                                <div class="col-md-4">

                                       <?php if ($is_tax == 0 ): ?>
                                            <label><input type="checkbox" name="purchase" id="p2"> ใบกำกับภาษี</label><br />
                                        <?php else: ?>
                                            <label><input type="checkbox" name="purchase" id="p2" checked> ใบกำกับภาษี</label><br />
                                        <?php endif ?>


                                </div>
                              </div>

                            <?php if ($is_tax == 1): ?>
                                <!-- Text input-->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="company">ชื่อบริษัท / ร้าน</label>
                                <div class="col-md-4">
                                <?php if( $isUsername == 1) {?>
                                  <input id="company" name="company" type="text" placeholder="ชื่อบริษัท / ร้าน" value="<?php echo $username_login["Company"]; ?>" class="form-control input-md">
                                <?php } else { ?>
                                  <input id="company" name="company" type="text" placeholder="ชื่อบริษัท / ร้าน" class="form-control input-md">
                                <?php } ?>

                                </div>
                              </div>


                              <!-- Textarea -->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="purchase_address">ชื่อ / ที่อยู่สำหรับออกใบกำกับภาษี</label>
                                <div class="col-md-4">
                                  <?php if( $isUsername == 1) {?>
                                      <textarea class="form-control" name="purchase_address"><?php echo trim($username_login["AVat"]);?></textarea>
                                  <?php } else { ?>
                                      <textarea class="form-control" name="purchase_address"></textarea>
                                  <?php } ?>
                                </div>
                              </div>

                              <!-- Text input-->
                              <div class="form-group" >
                                <label class="col-md-4 control-label" for="IDCARD">เลขประจำตัวผู้เสียภาษี</label>
                                <div class="col-md-4">
                                <?php if( $isUsername == 1) {?>
                                  <input id="IDCARD" name="IDCARD" type="text" placeholder="เลขประจำตัวผู้เสียภาษี" value="<?php echo $username_login["Nid"]; ?>" class="form-control input-md">
                                <?php } else { ?>
                                  <input id="IDCARD" name="IDCARD" type="text" placeholder="เลขประจำตัวผู้เสียภาษี" class="form-control input-md">
                                <?php } ?>

                                </div>
                              </div>


                            <?php endif ?>


                              <!-- Text input-->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="textinput">ชื่อผู้รับ</label>
                                <div class="col-md-4">
                                  <?php if( $isUsername == 1) {?>
                                      <input type="text" name="txtName"  placeholder="ชื่อผู้รับ" class="form-control input-md" required="required"
                                      value="<?php echo $username_login["FullName"] ." ". $username_login["LastName"]; ?>"/>
                                  <?php } else { ?>
                                      <input type="text" name="txtName"  placeholder="ชื่อผู้รับ" class="form-control input-md" required="required"
                                  value=""/>
                                  <?php } ?>
                                </div>
                              </div>

                              <!-- Textarea -->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="textarea">ที่อยู่จัดส่ง</label>
                                <div class="col-md-4">
                                  <?php if( $isUsername == 1) {?>
                                      <textarea class="form-control" name="txtAddress"><?php echo trim($username_login["ARecieve"]);?></textarea>
                                  <?php } else { ?>
                                      <textarea class="form-control" name="txtAddress"></textarea>
                                  <?php } ?>
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-md-4 control-label" for="passwordinput">เบอร์โทร</label>
                                <div class="col-md-4">
                                  <?php if( $isUsername == 1) {?>
                                      <input type="text" name="txtTel" id="txtTel" required="required" class="form-control input-md" placeholder="เบอร์โทร" maxlength="12" value="<?php echo $username_login["Mobile"];?>" />
                                  <?php } else { ?>
                                      <input type="text" name="txtTel" id="txtTel" class="form-control input-md" placeholder="เบอร์โทร" required="required" maxlength="12" value="" />
                                  <?php } ?>
                                </div>
                              </div>


                              <!-- Select Basic -->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="txtTransport">เลือกการจัดส่ง</label>
                                <input type="hidden" name="shipping_price" value="{{shipping_price + spcial_price}}">
                                <div class="col-md-4">

                                     <select id="txtTransport" name="txtTransport" class="form-control" ng-model="txtTransport" ng-change="changeShipping(txtTransport)"
                                            ng-model="txtTransport"
                                            ng-options="shipping.id as shipping.name for shipping in shipping_method track by shipping.id "
                                            required>
                                      <option value="">เลือกวิธีการจัดส่ง</option>
                                    </select>
                                    <span ng-show="form1.txtTransport.$error.required" class="text-danger">กรุณาเลือกวิธีการจัดส่ง</span>
                                    <p>ค่าจัดส่งสินค้า : {{shipping_price + spcial_price}}</p>
                                  </div>

                              </div>

                            <div class="well" ng-if="txtTransport==2">
                                 <div class="form-group" ng-if="txtTransport==2">
                                  <label class="col-md-4 control-label" for="province">จังหวัด</label>
                                  <div class="col-md-4">
                                      <select id="province" name="province" class="form-control"  ng-change="changeProvince(province)"
                                            ng-model="province"
                                            ng-options="province.id as province.name for province in province_list track by province.id "
                                            required>
                                            <option value="">เลือกจังหวัด</option>
                                      </select>
                                      <span ng-show="form1.province.$error.required" class="text-danger">กรุณาเลือกจังหวัด</span>
                                  </div>
                              </div>
                              <div class="form-group" ng-if="items.length > 1">
                                  <label class="col-md-4 control-label" for="amphur_id">อำเภอ</label>
                                  <div class="col-md-4">
                                      <select id="amphur_id" name="amphur_id" class="form-control"  ng-change="changeAmphur(amphur_id)"
                                            ng-model="amphur_id"
                                            ng-options="amphur.id as amphur.name for amphur in items track by amphur.id "
                                            required>
                                            <option value="">เลือกอำเภอ</option>
                                      </select>
                                      <span ng-show="form1.amphur_id.$error.required" class="text-danger">กรุณาเลือกอำเภอ</span>
                                  </div>
                              </div>
                            </div>

                              <!-- Text input-->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="txtEmail">อีเมล์</label>
                                <div class="col-md-4">
                                <?php if( $isUsername == 1) {?>
                                      <input type="text" name="txtEmail" id="txtEmail" required="required "placeholder="อีเมล์"  class="form-control input-md" value="<?php echo $username_login["Email"];?>" />
                                  <?php } else { ?>
                                      <input id="txtEmail" name="txtEmail" type="email" placeholder="อีเมล์" class="form-control input-md" required="required">
                                  <?php } ?>
                                </div>
                              </div>

                              <!-- Button -->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="singlebutton"></label>
                                <div class="col-md-4">
                                <div class="form-content">
                                  <button type="submit" name="Submit">
                                    <span>
                                      ยืนยันการสั่งซื้อ
                                    </span>
                                  </button>
                                </div>

                                  <div class="form-group" ng-if="isProscess==true">
                                    <hr>
                                        <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" style="width:70%"></div>
                                    </div>
                                  </div>
                                  <h4 class="text-success" ng-bind="message_prosecss"></h4>

                                </div>
                              </div>
                              </fieldset>
                          </form>
                </div>

                <div ng-if="sumTotal() < 1 " class="commerce">
                  <p class="label label-info">คุณไม่มีสินค้าในตะกร้า</p>
                           <div class="cart-button">
                                <a href="<?php echo base_url('products') ?>">
                                    <i class="fa fa-angle-left"></i> กลับไปเลือกสินค้า
                                </a>

                            </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div style="padding-bottom: 50px;"></div>
